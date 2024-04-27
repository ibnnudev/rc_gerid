<?php

namespace App\Repositories;

use App\Interfaces\SlideInterface;
use App\Models\Slide;
use Illuminate\Support\Facades\Storage;

class SlideRepository implements SlideInterface
{
    private $slide;

    public function __construct(Slide $slide)
    {
        $this->slide = $slide;
    }

    public function get()
    {
        $result = $this->slide->all();

        return $result;
    }

    public function getById($id)
    {
        return $this->slide->find($id);
    }

    public function store($data)
    {
        $filename = uniqid().'.'.$data['image']->getClientOriginalExtension();
        $data['image']->storeAs('public/slides', $filename);
        $data['image'] = $filename;

        return $this->slide->create($data);
    }

    public function update($id, $data)
    {
        $slide = $this->slide->find($id);
        if (isset($data['image'])) {
            $filename = uniqid().'.'.$data['image']->getClientOriginalExtension();
            $data['image']->storeAs('public/slides', $filename);
            $data['image'] = $filename;
        }

        return $slide->update($data);
    }

    public function destroy($id)
    {
        $slide = $this->slide->find($id);
        Storage::delete('public/slides/'.$slide->image);

        return $slide->delete();
    }
}
