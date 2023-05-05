<?php

namespace App\Models;

use App\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new HasActiveScope);
    }

    public $table = 'samples';

    public $fillable = [
        'sample_code',
        'file_code',
        'viruses_id',
        'gene_name',
        'size_gene',
        'sequence_data',
        'place',
        'pickup_date',
        'citation_id',
        'genotipes_id',
        'province_id',
        'regency_id',
        'virus_code',
        'is_active',
        'sequence_data_file',
        'created_by',
        'is_queue'
    ];

    // Relationship
    public function citation()
    {
        return $this->belongsTo(Citation::class, 'citation_id');
    }

    public function genotipe()
    {
        return $this->belongsTo(Genotipe::class, 'genotipes_id');
    }

    public function virus()
    {
        return $this->belongsTo(Virus::class, 'viruses_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'regency_id');
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
