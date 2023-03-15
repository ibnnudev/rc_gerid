<?php

namespace App\Imports;

use App\Models\District;
use App\Models\HivCases;
use App\Models\Regency;
use App\Models\Transmission;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class HivCasesImport implements ToCollection, WithBatchInserts, WithMultipleSheets
{

    public function collection(Collection $collection)
    {
        $collection->shift();
        $collection->shift();
        foreach ($collection as $data) {
            $result = HivCases::create([
                'idkd'            => $data[1],
                'idkd_address'    => $data[2],
                'latitude'        => $data[3],
                'longitude'       => $data[4],
                'regency_id'      => Regency::where('name', 'like', '%' . strtolower($data[5]) . '%')->first()['id'] ?? null,
                'district_id'     => District::where('name', 'like', '%' . strtolower($data[6]) . '%')->first()['id'] ?? null,
                'province_id'     => Regency::where('name', 'like', '%' . strtolower($data[5]) . '%')->first()->province_id ?? null,
                'region'          => strtolower($data[7]) == 'east' ? 'Timur' : (strtolower($data[7]) == 'west' ? 'Barat' : (strtolower($data[7]) == 'north' ? 'Utara' : (strtolower($data[7]) == 'south' ? 'Selatan' : 'Pusat'))),
                'count_of_cases'  => (int) $data[8],
                'age'             => (int) $data[9],
                'age_group'       => $data[10] ?? null,
                'sex'             => strtolower($data[11]) == 'male' ? 1 : 2,
                'transmission_id' => Transmission::where('name', 'like', '%' . strtolower($data[12]) . '%')->first()['id'] ?? null,
                'year'            => (int) $data[13],
            ]);

            // dd($result['transmission_id']);
        }
    }

    public function batchSize(): int
    {
        return 2000;
    }

    public function sheets(): array
    {
        return [
            0 => new HivCasesImport(),
        ];
    }
}
