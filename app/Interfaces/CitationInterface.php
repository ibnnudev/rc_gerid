<?php

namespace App\Interfaces;

interface CitationInterface
{
    public function get();

    public function store($data);

    public function find($id);

    public function update($data, $id);
}
