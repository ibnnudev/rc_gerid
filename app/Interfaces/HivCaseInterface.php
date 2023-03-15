<?php

namespace App\Interfaces;

interface HivCaseInterface {
    public function get();
    public function find($id);
    public function store($data);
    public function destroy($id);
    public function update($data, $id);
}
