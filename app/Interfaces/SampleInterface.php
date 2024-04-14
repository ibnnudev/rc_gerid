<?php

namespace App\Interfaces;

interface SampleInterface
{
    public function get();

    public function find($id);

    public function store($data);

    public function update($data, $id);

    public function destroy($id);

    // Advanced Search
    public function getAttributes();
    public function advancedSearch($data);

    // Sequence
    public function deleteByFileCode($fileCode);

    public function recoveryByFileCode($fileCode);

    public function getByFileCode($fileCode);

    public function getAllGroupByVirus();

    public function getSampleVirusByGen($name);

    public function getByAuthorByVirusId($id);
}
