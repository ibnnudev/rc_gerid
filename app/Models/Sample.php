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

    public static function generateSampleCode()
    {
        // combination SMP-Y-M-D-0001
        $date = date('Y-m-d');
        $date = explode('-', $date);
        $year = $date[0];
        $month = $date[1];
        $day = $date[2];

        $sampleCode = 'SMP-' . $year . '-' . $month . '-' . $day . '-';
        $lastSampleCode = Sample::where('sample_code', 'like', $sampleCode . '%')->orderBy('sample_code', 'desc')->first();

        if ($lastSampleCode) {
            $lastSampleCode = explode('-', $lastSampleCode->sample_code);
            $lastSampleCode = $lastSampleCode[4];
            $lastSampleCode = (int) $lastSampleCode;
            $lastSampleCode += 1;
            $lastSampleCode = str_pad($lastSampleCode, 4, '0', STR_PAD_LEFT);
            $sampleCode .= $lastSampleCode;
        } else {
            $sampleCode .= '0001';
        }

        return $sampleCode;
    }
}
