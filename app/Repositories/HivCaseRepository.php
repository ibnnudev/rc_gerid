<?php

namespace App\Repositories;

use App\Interfaces\HivCaseInterface;
use App\Models\HivCases;

class HivCaseRepository implements HivCaseInterface
{
    private $hivCase;

    public function __construct(HivCases $hivCase) {
        $this->hivCase = $hivCase;
    }

    public function get()
    {
        return $this->hivCase->with(['province', 'regency', 'district', 'transmission'])->get();
    }
}
