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

    public function supervisorRosters()
    {
        return $this->hasMany(Roster::class, 'supervisor', 'id');
    }

    public function doctorRosters()
    {
        return $this->hasMany(Roster::class, 'doctor', 'id');
    }

    public function caregiver1Rosters()
    {
        return $this->hasMany(Roster::class, 'caregiver1', 'id');
    }

    public function caregiver2Rosters()
    {
        return $this->hasMany(Roster::class, 'caregiver2', 'id');
    }

    public function caregiver3Rosters()
    {
        return $this->hasMany(Roster::class, 'caregiver3', 'id');
    }

    public function caregiver4Rosters()
    {
        return $this->hasMany(Roster::class, 'caregiver4', 'id');
    }
    
}
