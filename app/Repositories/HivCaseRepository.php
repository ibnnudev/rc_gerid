<?php

namespace App\Repositories;

use App\Interfaces\HivCaseInterface;
use App\Models\HivCases;

class HivCaseRepository implements HivCaseInterface
{
    private $hivCase;

    public function __construct(HivCases $hivCase)
    {
        $this->hivCase = $hivCase;
    }

    public function get()
    {
        return $this->hivCase->with(['province', 'regency', 'district', 'transmission'])->orderBy('id', 'DESC')->get();
    }

    public function find($id)
    {
        return $this->hivCase->with(['province', 'regency', 'district', 'transmission'])->find($id);
    }

    public function store($data)
    {
        $this->hivCase->create([
            'idkd'            => $data['idkd'],
            'idkd_address'    => $data['idkd_address'],
            'latitude'        => $data['latitude'],
            'longitude'       => $data['longitude'],
            'province_id'     => $data['province_id'],
            'regency_id'      => $data['regency_id'],
            'district_id'     => $data['district_id'],
            'region'          => $data['region'],
            'count_of_cases'  => $data['count_of_cases'],
            'age'             => $data['age'],
            'age_group'       => $data['age_group'],
            'sex'             => $data['sex'],
            'transmission_id' => $data['transmission_id'],
            'year'            => $data['year']
        ]);

        return true;
    }

    public function destroy($id)
    {
        $this->hivCase->find($id)->update([
            'is_active' => 0
        ]);

        return true;
    }

    public function update($data, $id)
    {
        $this->hivCase->find($id)->update([
            'idkd'            => $data['idkd'],
            'idkd_address'    => $data['idkd_address'],
            'latitude'        => $data['latitude'],
            'longitude'       => $data['longitude'],
            'province_id'     => $data['province_id'],
            'regency_id'      => $data['regency_id'],
            'district_id'     => $data['district_id'],
            'region'          => $data['region'],
            'count_of_cases'  => $data['count_of_cases'],
            'age'             => $data['age'],
            'age_group'       => $data['age_group'],
            'sex'             => $data['sex'],
            'transmission_id' => $data['transmission_id'],
            'year'            => $data['year']
        ]);

        return true;
    }
}
