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
        'sequence_date',
        'place',
        'city',
        'subdistrict',
        'region',
        'pickup_date',
        'authors_id',
        'genotipes_id',
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
}
