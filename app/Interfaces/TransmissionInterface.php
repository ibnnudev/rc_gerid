<?php

namespace App\Interfaces;

interface TransmissionInterface
{
    public function get();
    public function store($data);
    public function find($id);
    public function update($data, $id);
    public function destroy($id);
}
