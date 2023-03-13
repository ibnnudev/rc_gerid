<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citation extends Model
{
    use HasFactory;

    public $table = 'citations';

    protected $fillable = [
        'title',
        'author_id', // multi author (separated by comma)
        'samples_id',
        'users_id',
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
