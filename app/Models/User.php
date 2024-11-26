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

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);  // A user can have many patients
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
}
