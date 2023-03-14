<?php

namespace App\Interfaces;

interface SampleInterface {
    public function get();
    public function find($id);
    public function store($data);
    public function update($data, $id);
    public function destroy($id);
}
