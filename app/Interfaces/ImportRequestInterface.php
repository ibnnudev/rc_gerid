<?php

namespace App\Interfaces;

interface ImportRequestInterface
{
    public function get();
    public function find($id);
    public function store($data);
    public function update($data, $id);
    public function destroy($id);
}
