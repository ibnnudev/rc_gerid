<?php

namespace App\Interfaces;

interface AuthorInterface
{
    public function get();
    public function store($data): bool;
    public function destroy($id): bool;
    public function find($id);
    public function update($data, $id): bool;
}
