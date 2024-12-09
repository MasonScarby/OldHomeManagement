<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'patient_id',
        'caregiver_id',
        'morning_med_status',
        'afternoon_med_status',
        'night_med_status',
        'breakfast_status',
        'lunch_status',
        'dinner_status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function caregiver()
    {
        return $this->belongsTo(User::class, 'caregiver_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}