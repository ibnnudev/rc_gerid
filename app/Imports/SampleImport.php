<?php

namespace App\Imports;

use App\Models\Author;
use App\Models\Citation;
use App\Models\Genotipe;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Sample;
use App\Models\Virus;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SampleImport implements ToModel, WithBatchInserts, WithStartRow, WithValidation
{

    public $file_code;
    public function __construct($file_code) {
        $this->file_code = $file_code;
    }

    public function startRow(): int
    {
        return 3;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function rules(): array
    {
        // set all field must be required
        return [
            '*.0' => 'required',
            '*.1' => 'required',
            '*.2' => 'required',
            '*.3' => ['required', 'regex:/^(Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember)$/'],
            '*.4' => 'required',
            '*.5' => 'required',
            '*.6' => 'required',
            '*.7' => 'required',
            '*.8' => 'required',
            '*.9' => 'required',
            '*.10' => 'required',
            '*.11' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        // indonesia validation message
        return [
            '*.0.required' => 'Kolom kode sampel harus diisi',
            '*.1.required' => 'Kolom virus harus diisi',
            '*.2.required' => 'Kolom genotipe harus diisi',
            '*.3.required' => 'Kolom bulan pengambilan sampel harus diisi',
            '*.3.regex'    => 'Kolom bulan pengambilan sampel harus diisi dengan bulan menggunakan bahasa indonesia',
            '*.4.required' => 'Kolom tahun pengambilan sampel harus diisi',
            '*.5.required' => 'Kolom tempat pengambilan sampel harus diisi',
            '*.6.required' => 'Kolom provinsi harus diisi',
            '*.7.required' => 'Kolom kabupaten/kota harus diisi',
            '*.8.required' => 'Kolom nama gen harus diisi',
            '*.9.required' => 'Kolom data sekuen harus diisi',
            '*.10.required' => 'Kolom judul harus diisi',
            '*.11.required' => 'Kolom penulis harus diisi',
        ];
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
        $citation_id   = isset($title, $authors) ? $this->citation($title, $authors) : null;

        /* check if sample code is already exist */
        $sample = Sample::pluck('sample_code', 'id')->toArray();
        $sample = array_search($sampleCode, $sample);

        if (!empty($sample)) {
            return null;
        }

        $data = [
            'sample_code'   => $sampleCode,
            'file_code'     => $this->file_code ?? null,
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
        $citation = Citation::pluck('title', 'id')->toArray();
        $citation = array_search($title, $citation);

        if (empty($citation) && $title != null && $authors != null) {
            $citation = Citation::create([
                'id'       => Citation::max('id') + 1,
                'title'    => $title,
                'author_id'  => $authors,
                'users_id' => auth()->user()->id
            ]);
            return $citation->id;
        } else {
            return $citation;
        }
    }

    public function authors($param)
    {
        $name = explode(',', $param)[0];
        $author = Author::pluck('name', 'id')->toArray();
        $author = array_search($name, $author);

        if (empty($author)) {
            $firstAuthor = $name;
            $author = Author::create([
                'id'     => Author::max('id') + 1,
                'name'   => $firstAuthor,
                'member' => $param
            ]);
            return $author->id;
        } else {
            return $author;
        }
    }

    public function province($param)
    {
        $param = strtoupper($param);
        $province = Province::pluck('name', 'id')->toArray();
        $province = array_search($param, $province);

        if (empty($province)) {
            $province = Province::create([
                'id'   => Province::max('id') + 1,
                'name' => $param
            ]);
            return $province->id;
        } else {
            return $province;
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
        // translate indonesia month to english month in number
        $month = [
            'Januari'   => '01',
            'Februari'  => '02',
            'Maret'     => '03',
            'April'     => '04',
            'Mei'       => '05',
            'Juni'      => '06',
            'Juli'      => '07',
            'Agustus'   => '08',
            'September' => '09',
            'Oktober'   => '10',
            'November'  => '11',
            'Desember'  => '12',
        ];

        if (array_key_exists($pickup_month, $month)) {
            $pickup_month = $month[$pickup_month];
        }

        if ($pickup_month != null && $pickup_year != null) {
            $pickup_date = $pickup_year . '-' . $pickup_month . '-01';
        } else if ($pickup_month == null && $pickup_year != null) {
            $pickup_date = $pickup_year . '-01-01';
        } else if ($pickup_month != null && $pickup_year == null) {
            $pickup_date = '0000-' . $pickup_month . '-01';
        } else {
            $pickup_date = null;
        }

        return $pickup_date;
    }

    public function virus($param)
    {
        $virus = Virus::where('name', 'like', '%' . $param . '%')->first();
        return $virus->id;
    }

    public function genotipe($param, $virus)
    {
        $genotipe = Genotipe::pluck('genotipe_code', 'id')->toArray();
        $genotipe = array_search($param, $genotipe);

        if(empty($genotipe)) {
            $genotipe = Genotipe::create([
                'id' => Genotipe::max('id') + 1,
                'genotipe_code' => $param,
                'viruses_id'    => $virus
            ]);

            return $genotipe->id;
        } else {
            return $genotipe;
        }
    }
}
