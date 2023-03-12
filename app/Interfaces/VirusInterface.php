<?php

namespace App\Interfaces;

interface VirusInterface {
    public function get();
    public function store($data): bool;
    public function find($id);
    public function update($data, $id): bool;
    public function destroy($id): bool;
}
