<?php

namespace App\Repositories;

use App\Interfaces\VirusInterface;
use App\Models\Virus;
use Illuminate\Support\Facades\Storage;
<<<<<<< HEAD
use Illuminate\Support\Facades\File;
use Image;
=======
>>>>>>> cb8289b (update)

class VirusRepository implements VirusInterface
{
    private $virus;

    public function __construct(Virus $virus)
    {
        $this->virus = $virus;
    }

    public function get()
    {
        return $this->virus->get();
    }

    public function store($data): bool
    {
        if ($data['image']) {
            $filename = time() . '.' . $data['image']->getClientOriginalExtension();
<<<<<<< HEAD
            $destinationPath = public_path('images');
            $img = Image::make($data['image']->path());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $filename);
            $data['image']->move($destinationPath, $filename);
            // $data['image']->storeAs('public/virus', $filename);
=======
            $data['image']->storeAs('public/virus', $filename);
>>>>>>> cb8289b (update)

            $data['image'] = $filename;
        }

        $this->virus->create($data);

        return true;
    }

    public function find($id)
    {
        return $this->virus->find($id);
    }

    public function update($data, $id): bool
    {
        $virus = $this->virus->find($id);

        if (isset($data['image'])) {

            // delete old files
            if ($virus->image) {
<<<<<<< HEAD
                if (file_exists(public_path('images/') . $virus->image)) {
                    File::delete(public_path('images/') . $virus->image);
=======
                $oldFile = 'public/virus/' . $virus->image;
                if (Storage::exists($oldFile)) {
                    Storage::delete($oldFile);
>>>>>>> cb8289b (update)
                }
            }

            $filename = time() . '.' . $data['image']->getClientOriginalExtension();
<<<<<<< HEAD
            $destinationPath = public_path('images');
            $img = Image::make($data['image']->path());
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $filename);
            $data['image']->move($destinationPath, $filename);
=======
            $data['image']->storeAs('public/virus', $filename);
>>>>>>> cb8289b (update)

            $data['image'] = $filename;
            $virus->image = $data['image'];
        }

        $virus->name        = $data['name'];
        $virus->latin_name  = $data['latin_name'];
        $virus->description = $data['description'];

        $virus->save();

        return true;
    }

    public function destroy($id): bool
    {
        $virus = $this->virus->find($id);
        $virus->setInactive();

        return true;
    }
}
