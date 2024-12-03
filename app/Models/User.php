<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'role_id',
        'is_approved'
    ];

//apointments page
    public function appointmentsAsPatient()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function appointmentsAsDoctor()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }
// roles
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    //newRoster -> dont need i think
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    //payment 
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
    public function superviser()
    {
        return $this->hasMany(Roster::class, 'supervisor', 'id');
    }

    /**
     * Get the rosters where the user is the doctor.
     */
    public function doctor()
    {
        return $this->hasMany(Roster::class, 'doctor', 'id');
    }

    /**
     * Get the rosters where the user is one of the caregivers.
     */
    public function caregiver1()
    {
        return $this->hasMany(Roster::class, 'caregiver1', 'id');
    }

    public function caregiver2()
    {
        return $this->hasMany(Roster::class, 'caregiver2', 'id');
    }

    public function caregiver3()
    {
        return $this->hasMany(Roster::class, 'caregiver3', 'id');
    }

    public function caregiver4()
    {
        return $this->hasMany(Roster::class, 'caregiver4', 'id');
    }

    public function caregiverLogs()
    {
        return $this->hasMany(PatientLog::class, 'caregiver_id');
    }
}
