<?php

namespace App\Repositories;

use App\Interfaces\CitationInterface;
use App\Models\Citation;

class CitationRepository implements CitationInterface
{
    private $citation;

    public function __construct(Citation $citation)
    {
        $this->citation = $citation;
    }

    public function get()
    {
        return $this->citation->with('author')->get();
    }

    public function store($data)
    {
        return $this->citation->create([
            'title' => $data['title'],
            'author_id' => $data['author'],
            'users_id' => auth()->user()->id,
        ]);
    }

    public function find($id)
    {
        return $this->citation->with('author')->find($id);
    }

    public function update($data, $id)
    {
        return $this->citation->find($id)->update([
            'title' => $data['title'],
            'author_id' => $data['author'],
        ]);
    }
}
