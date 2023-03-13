<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;

    public $table = 'villages';

    public $fillable = [
        'id',
        'district_id',
        'name',
    ];

    public $timestamps = false;

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function regency()
    {
        return $this->belongsToThrough(Regency::class, District::class);
    }

    public function province()
    {
        return $this->belongsToThrough(Province::class, District::class, Regency::class);
    }
}
