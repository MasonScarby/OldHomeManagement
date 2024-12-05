<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id', 
        'doctor_id', 
        'patient_id', 
        'morning_med', 
        'afternoon_med', 
        'night_med', 
        'comment', 
        'date',
    ];

}
