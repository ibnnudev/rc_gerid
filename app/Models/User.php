<?php

namespace App\Models;

use App\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const USER_ROLE  = 'user';
    const ADMIN_ROLE = 'admin';
    const VALIDATOR_ROLE = 'validator';

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'google_id',
        'role',
        'avatar',
        'remember_token',
        'virus_id',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRole() {
        return $this->role;
    }

    // Relationships

    public function virus()
    {
        return $this->belongsTo(Virus::class, 'virus_id');
    }

    public function citations()
    {
        return $this->hasMany(Citation::class, 'users_id');
    }

    public function importedBy()
    {
        return $this->hasMany(ImportRequest::class, 'imported_by');
    }

    public function acceptedBy()
    {
        return $this->hasMany(ImportRequest::class, 'accepted_by');
    }

    public function rejectedBy()
    {
        return $this->hasMany(ImportRequest::class, 'rejected_by');
    }
}
