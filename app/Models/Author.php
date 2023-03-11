<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    public $table = 'authors';

    public $fillable = [
        'name',
        'address',
        'phone',
        'member',
        'institution',
    ];

    // Relationship
    public function samples()
    {
        return $this->hasMany(Sample::class, 'authors_id');
    }


}
