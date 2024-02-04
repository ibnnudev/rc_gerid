<?php

namespace App\Interfaces;

interface FrontendInterface
{
    public function getVirus($id);
    public function getAllSampleByVirus($id);
    public function hivCases();
    public function listCitations($request);
    public function detailCitation($id);
    public function detailFasta($id);
    public function getVirusByName($name);
}
