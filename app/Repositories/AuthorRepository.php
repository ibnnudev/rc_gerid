<?php

namespace App\Repositories;

use App\Interfaces\AuthorInterface;
use App\Models\Author;

class AuthorRepository implements AuthorInterface
{
    private $author;

    public function __construct(Author $author)
    {
        $this->author = $author;
    }

    public function get()
    {
        return $this->author->with('institution')->get();
    }

    public function store($data): bool
    {

        $this->author->create([
            'name' => $data['name'],
            'member' => $data['member'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'],
            'institutions_id' => $data['institutions_id'],
        ]);

        return true;
    }

    public function destroy($id): bool
    {
        $author = $this->author->find($id);
        $author->setInactive();

        return true;
    }

    public function find($id)
    {
        return $this->author->with('institution')->find($id);
    }

    public function update($data, $id): bool
    {
        $this->author->where('id', $id)->update([
            'name' => $data['name'],
            'member' => $data['member'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'],
            'institutions_id' => $data['institutions_id'],
        ]);

        return true;
    }
}
