<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    use HasFactory;

    public $table = 'samples';

    public $fillable = [
        'sample_code',
        'viruses_id',
        'gene_name',
        'sequence_data',
        'place',
        'city',
        'subdistrict',
        'region',
        'pickup_date',
        'authors_id',
        'genotipes_id',
        'virus_code'
    ];

    // Relationship
    public function author()
    {
        return $this->belongsTo(Author::class, 'authors_id');
    }

    public function genotipe()
    {
        return $this->belongsTo(Genotipe::class, 'genotipes_id');
    }

    public function virus()
    {
        return $this->belongsTo(Virus::class, 'viruses_id');
    }

    public function citations()
    {
        return $this->hasMany(Citation::class, 'samples_id');
    }

    // generate virus code
    public function generateVirusCode()
    {
        // // prefix : nama virus + tahun + bulan + tanggal + detik
        // $prefix = $this->virus->name . now()->format('Ym') . now()->format('d') . now()->format('s');

        // // suffix : kode genotipe + kode sample
        // $suffix = $this->genotipe->code . $this->sample_code;

        // // generate virus code
        // $this->virus_code = $prefix . $suffix;
    }
}
