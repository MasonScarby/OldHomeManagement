<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Roster extends Model
{
    protected $fillable = [
        'date',
        'supervisor_id',
        'doctor_id',
        'caregiver1_id',
        'caregiver2_id',
        'caregiver3_id',
        'caregiver4_id',
    ];

    // Define the relationship to Supervisor
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    // Define the relationship to Doctor
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    // Define the relationship to Caregiver 1
    public function caregiver1()
    {
        return $this->belongsTo(User::class, 'caregiver1_id');
    }

    // Define the relationship to Caregiver 2
    public function caregiver2()
    {
        return $this->belongsTo(User::class, 'caregiver2_id');
    }

    // Define the relationship to Caregiver 3
    public function caregiver3()
    {
        return $this->belongsTo(User::class, 'caregiver3_id');
    }

    // Define the relationship to Caregiver 4
    public function caregiver4()
    {
        return $this->belongsTo(User::class, 'caregiver4_id');
    }
}
