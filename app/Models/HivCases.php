<?php

namespace App\Models;

use App\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HivCases extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new HasActiveScope);
    }

    public $table = 'hiv_cases';

    protected $fillable = [
        'idkd',
        'idkd_address',
        'latitude',
        'longitude',
        'regency_id',
        'district_id',
        'province_id',
        'region', // Timur, Barat, Utara, Selatan, Pusat
        'count_of_cases',
        'age',
        'age_group',
        'sex',
        'transmission_id',
        'year',
        'is_active',
    ];

    // Relationships
    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function transmission()
    {
        return $this->belongsTo(Transmission::class);
    }

    public function setInactive()
    {
        $this->is_active = false;
        $this->save();
    }
}
