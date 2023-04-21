<?php

namespace App\Models;

use App\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportRequest extends Model
{

    protected static function booted()
    {
        static::addGlobalScope(new HasActiveScope);
    }

    use HasFactory;

    public $table = 'import_requests';

    protected $fillable = [
        'filename',
        'status',
        'imported_by',
        'accepted_by',
        'rejected_by',
        'rejected_reason',
        'accepted_reason',
        'description',
        'is_active'
    ];

    // RELATIONSHIP

    public function importedBy()
    {
        return $this->belongsTo(User::class, 'imported_by');
    }

    public function acceptedBy()
    {
        return $this->belongsTo(User::class, 'accepted_by');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}
