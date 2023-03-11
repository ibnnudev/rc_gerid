<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Virus extends Model
{
    use HasFactory;

    public $table = 'viruses';

    protected $fillable = [
        'image',
        'name',
        'latin_name',
        'description',
    ];

    // Relationship
    public function genotipes()
    {
        return $this->hasMany(Genotipe::class, 'viruses_id');
    }

    public function samples()
    {
        return $this->hasManyThrough(Sample::class, Genotipe::class, 'viruses_id', 'genotipes_id');
    }
}
