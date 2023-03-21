<?php

namespace App\Imports;

use App\Models\Author;
use App\Models\Citation;
use App\Models\Genotipe;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Sample;
use App\Models\Virus;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SampleImport implements ToModel, WithBatchInserts, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function model(array $row)
    {
        $sampleCode = $row[0] ?? null;
        $virus      = $row[1] == null ? null : $this->virus($row[1]);
        $genotipe   = $row[2] == null ? null : $this->genotipe($row[2], $virus);

        $pickup_month = $row[3] ?? null;
        $pickup_year  = $row[4] ?? null;
        $pickup_date  = $this->pickupDate($pickup_month, $pickup_year);

        $place         = $row[5] ?? null;
        $province      = $row[6]  == null ? null : $this->province($row[6]);
        $regency       = $row[7]  == null ? null : $this->regency($row[7], $province);
        $gene          = $row[8] ?? null;
        $sequence_data = $row[9] ?? null;
        $title         = $row[10] ?? null;
        $authors       = $row[11] == null ? null : $this->authors($row[11]);
        $citation_id   = $this->citation($title, $authors);

        $data = [
            'sample_code'   => $sampleCode,
            'viruses_id'    => $virus,
            'gene_name'     => $gene,
            'sequence_data' => $sequence_data,
            'place'         => $place,
            'pickup_date'   => $pickup_date,
            'citation_id'   => $citation_id,
            'genotipes_id'  => $genotipe,
            'province_id'   => $province,
            'regency_id'    => $regency,
        ];

        return new Sample($data);
    }

    public function citation($title, $authors)
    {
        $citation = Citation::where('title', '=', $title)->first();
        if ($citation == null || $citation->title != $title) {
            $citation = Citation::create([
                'id'      => Citation::max('id') + 1,
                'title'   => $title,
                'authors' => $authors,
                'users_id' => auth()->user()->id
            ]);
            return $citation->id;
        } else {
            return $citation->id;
        }
    }

    public function authors($param)
    {
        $name = explode(',', $param)[0];
        $author = Author::where('name', '=', $name)->first();
        if ($author == null || $author->name != $name) {
            $firstAuthor = $name;
            $author = Author::create([
                'id'     => Author::max('id') + 1,
                'name'   => $firstAuthor,
                'member' => $param
            ]);
            return $author->id;
        } else {
            return $author->id;
        }
    }

    public function province($param)
    {
        $param = strtoupper($param);
        $province = Province::where('name', 'like', '%' . $param . '%')->first();
        if ($province == null || $province->name != $param) {
            $province = Province::create([
                'id'   => Province::max('id') + 1,
                'name' => $param
            ]);
            return $province->id;
        } else {
            return $province->id;
        }
    }


    public function regency($param, $province)
    {
        $param = strtoupper($param);
        $regency = Regency::where('name', 'like', '%' . $param . '%')->first();
        if ($regency == null || $regency->name != $param) {
            if ($province == null) {
                $province = $regency->province_id;
            } else {
                $regency = Regency::create([
                    'id'          => Regency::max('id') + 1,
                    'name'        => $param,
                    'province_id' => $province
                ]);
            }
            return $regency->id;
        } else {
            return $regency->id;
        }
    }

    public function pickupDate($pickup_month, $pickup_year)
    {
        if ($pickup_month != null && $pickup_year != null) {
            $pickup_date = $pickup_year . '-' . $pickup_month . '-01';
        } else if ($pickup_month == null && $pickup_year != null) {
            $pickup_date = $pickup_year . '-01-01';
        } else if ($pickup_month != null && $pickup_year == null) {
            $pickup_date = '0000-' . $pickup_month . '-01';
        } else {
            $pickup_date = null;
        }

        return date('Y-m-d', strtotime($pickup_date));
    }

    public function virus($param)
    {
        $virus = Virus::where('name', 'like', '%' . $param . '%')->first();
        return $virus->id;
    }

    public function genotipe($param, $virus)
    {
        $genotipe = Genotipe::where('genotipe_code', 'like', '%' . $param . '%')->first();
        if ($genotipe == null || $genotipe->genotipe_code != $param || $genotipe->viruses_id != $virus) {
            $genotipe = Genotipe::create([
                'genotipe_code' => $param,
                'viruses_id'    => $virus
            ]);
            return $genotipe->id;
        } else {
            return $genotipe->id;
        }
    }
}
