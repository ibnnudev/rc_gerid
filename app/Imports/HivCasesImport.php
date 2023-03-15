<?php

namespace App\Imports;

use App\Models\District;
use App\Models\HivCases;
use App\Models\Regency;
use App\Models\Transmission;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;

class HivCasesImport implements ToModel, WithMultipleSheets, WithBatchInserts, WithStartRow
{

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        return new HivCases([
            'idkd'            => $row[1],
            'idkd_address'    => $row[2],
            'latitude'        => $row[3],
            'longitude'       => $row[4],
            'regency_id'      => Regency::where('name', 'like', '%' . strtolower($row[5]) . '%')->first()['id'] ?? null,
            'district_id'     => District::where('name', 'like', '%' . strtolower($row[6]) . '%')->first()['id'] ?? null,
            'province_id'     => Regency::where('name', 'like', '%' . strtolower($row[5]) . '%')->first()->province_id ?? null,
            'region'          => strtolower($row[7]) == 'east' ? 'Timur' : (strtolower($row[7]) == 'west' ? 'Barat' : (strtolower($row[7]) == 'north' ? 'Utara' : (strtolower($row[7]) == 'south' ? 'Selatan' : 'Pusat'))),
            'count_of_cases'  => (int) $row[8],
            'age'             => (int) $row[9],
            'age_group'       => $row[10] ?? null,
            'sex'             => strtolower($row[11]) == 'male' ? 1 : 2,
            'transmission_id' => Transmission::where('name', 'like', '%' . strtolower($row[12]) . '%')->first()['id'] ?? null,
            'year'            => (int) $row[13],
        ]);
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
