<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Roster extends Model
{
    use HasFactory;

    protected $table = 'rosters'; 

    protected $fillable = [
        'date',
        'supervisor',
        'doctor',
        'caregiver1',
        'caregiver2',
        'caregiver3',
        'caregiver4',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
