<?php

namespace App\Models;

use App\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genotipe extends Model
{
    protected static function booted()
    {
        static::addGlobalScope(new HasActiveScope);
    }
    use HasFactory;

    public $table = 'genotipes';

    protected $fillable = [
        'viruses_id',
        'genotipe_code',
    ];

    // Relationship
    public function samples()
    {
        return $this->hasMany(Sample::class, 'genotipes_id');
    }

    public function virus()
    {
        return $this->belongsTo(Virus::class, 'viruses_id');
    }

    public function setInactive()
    {
        $this->is_active = false;
        $this->save();
    }
}
