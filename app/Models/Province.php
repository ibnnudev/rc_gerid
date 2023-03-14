<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    public $table = 'provinces';

    public $fillable = [
        'id',
        'name',
    ];

    public $timestamps = false;

    public function regencies()
    {
        return $this->hasMany(Regency::class);
    }

    public function districts()
    {
        return $this->hasManyThrough(District::class, Regency::class);
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
