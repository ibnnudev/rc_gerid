<?php

namespace App\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class NewImportRequestValidator implements WithValidation, WithStartRow, WithBatchInserts, ToModel
{

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
        // if empty row, return null
        if (empty($row[0])) {
            return null;
        }
    }
}
