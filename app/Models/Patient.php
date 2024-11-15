<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'family_code',
        'emergency_contact',
        'contact_relationship',
        'group',
        'admission_date',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
