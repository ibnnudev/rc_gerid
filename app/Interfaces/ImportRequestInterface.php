<?php

namespace App\Interfaces;

interface ImportRequestInterface
{
    public function get();
    public function find($id);
    public function store($data);
    public function update($data, $id);
    public function destroy($id);
    public function changeStatus($id, $status, $reason);
    public function import($id);
    public function imported($userId = null);
    public function storeSingle($data);
    public function updateSingle($data, $id);
    public function findByFileCode($fileCode);
    public function changeStatusSingle($id, $status);
}
