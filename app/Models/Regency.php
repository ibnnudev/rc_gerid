<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    use HasFactory;

    public $table = 'regencies';

    public $fillable = [
        'id',
        'province_id',
        'name',
    ];

    public $timestamps = false;

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function villages()
    {
        return $this->hasManyThrough(Village::class, District::class);
    }

    public function samples()
    {
        return $this->hasManyThrough(Sample::class, District::class);
    }
}
