<?php

namespace App\Models;

use App\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new HasActiveScope);
    }

    public $table = 'authors';

    public $fillable = [
        'name',
        'address',
        'phone',
        'member',
        'institutions_id',
        'is_active'
    ];

    // Relationship

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institutions_id');
    }

    public function citation()
    {
        return $this->hasMany(Citation::class, 'author_id');
    }

    public function setInactive()
    {
        $this->is_active = false;
        $this->save();
    }
}
