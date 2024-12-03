<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'supervisor',
        'doctor',
        'caregiver1',
        'caregiver2',
        'caregiver3',
        'caregiver4'
    ];

    // Define the relationship to Supervisor
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor', 'id');
    }

    // Define the relationship to Doctor
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor', 'id');
    }

    public function caregiver1()
    {
        return $this->belongsTo(User::class, 'caregiver1', 'id');
    }

    public function caregiver2()
    {
        return $this->belongsTo(User::class, 'caregiver2', 'id');
    }

    public function caregiver3()
    {
        return $this->belongsTo(User::class, 'caregiver3', 'id');
    }

    public function caregiver4()
    {
        return $this->belongsTo(User::class, 'caregiver4', 'id');
    }
}
