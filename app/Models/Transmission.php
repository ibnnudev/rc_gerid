<?php

namespace App\Models;

use App\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transmission extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new HasActiveScope);
    }

    public $table = 'transmissions';

    protected $fillable = [
        'name',
        'is_active',
    ];

    public function setInactive() {
        $this->is_active = false;
        $this->save();
    }

    // Relationships

    public function hivCases()
    {
        return $this->hasMany(HivCases::class);
    }
}
