<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    public $table = 'visitors';

    public $fillable = [
        'ip_address',
        'user_agent',
        'date',
    ];
}
