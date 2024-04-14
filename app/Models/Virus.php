<?php

namespace App\Models;

use App\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Virus extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new HasActiveScope);
    }

    public $table = 'viruses';

    protected $fillable = [
        'image',
        'name',
        'latin_name',
        'description',
        'is_active',
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

    public function setInactive()
    {
        $this->is_active = false;
        $this->save();
    }

    public function importRequests()
    {
        return $this->hasMany(ImportRequest::class, 'viruses_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'virus_id');
    }
}
