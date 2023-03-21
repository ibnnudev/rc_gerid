<?php

namespace App\Models;

use App\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citation extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new HasActiveScope);
    }

    public $table = 'citations';

    protected $fillable = [
        'title',
        'author_id', // multi author (separated by comma)
        'users_id',
        'is_active'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function sample()
    {
        return $this->hasMany(Sample::class, 'citation_id');
    }

    public function setInactive()
    {
        $this->is_active = 0;
        $this->save();
    }
}
