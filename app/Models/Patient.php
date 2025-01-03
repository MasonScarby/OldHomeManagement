<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $casts = [
        'admission_date' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // Additional relationships for appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function logs()
    {
        return $this->hasMany(PatientLog::class, 'patient_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
