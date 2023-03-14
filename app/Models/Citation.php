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
        'samples_id',
        'users_id',
        'is_active'
    ];

    // Relationships

    public function sample()
    {
        return $this->belongsTo(Sample::class, 'samples_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
}
