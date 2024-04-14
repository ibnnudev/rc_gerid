<?php

namespace App\Imports;

use App\Models\District;
use App\Models\HivCases;
use App\Models\Regency;
use App\Models\Transmission;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;

class HivCasesImport implements ToModel, WithBatchInserts, WithMultipleSheets, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $_regency = Regency::where('name', 'like', '%'.strtolower($row[5]).'%')->first()->id;
        $_district = strtolower($row[6]);
        $province = Regency::where('id', $_regency)->first()->province_id;

        $district = District::where('name', 'like', '%'.$_district.'%')->first();
        $newDistrict = [];
        if ($district == null || $district->regency_id != $_regency) {
            $newDistrict = [
                'id' => District::max('id') + 1,
                'name' => strtoupper($_district),
                'regency_id' => $_regency,
            ];
            District::create($newDistrict);
            $district = $newDistrict['id'];
        } else {
            $district = $district->id;
        }

        $data = [
            'idkd' => $row[1],
            'idkd_address' => $row[2],
            'latitude' => $row[3],
            'longitude' => $row[4],
            'regency_id' => $_regency,
            'district_id' => $district,
            'province_id' => $province,
            'region' => $this->findRegion($row[7]),
            'count_of_cases' => (int) $row[8],
            'age' => (int) $row[9],
            'age_group' => $row[10],
            'sex' => strtolower($row[11]) == 'male' ? 1 : 2,
            'transmission_id' => Transmission::where('name', 'like', '%'.strtolower($row[12]).'%')->first()->id,
            'year' => (int) $row[13],
        ];

        return new HivCases($data);
    }

    public function findRegion($region)
    {
        return strtolower($region) == 'east' ? 'Timur' : (strtolower($region) == 'west' ? 'Barat' : (strtolower($region) == 'north' ? 'Utara' : (strtolower($region) == 'south' ? 'Selatan' : 'Pusat')));
    }

    public function sheets(): array
    {
        return [
            0 => new HivCasesImport(),
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
