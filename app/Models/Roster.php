<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
<<<<<<< HEAD
    protected $fillable = [
        'date',
        'supervisor_id',
        'doctor_id',
        'caregiver1_id',
        'caregiver2_id',
        'caregiver3_id',
        'caregiver4_id',
=======
    use HasFactory;

    protected $fillable = [
        'date',
        'supervisor',
        'doctor',
        'caregiver1',
        'caregiver2',
        'caregiver3',
        'caregiver4'
>>>>>>> 563e630463dddbbb43d52ef8c6eade0a97247e85
    ];

    // Define the relationship to Supervisor
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor', 'id');
    }

<<<<<<< HEAD
    // Define the relationship to Doctor
=======
>>>>>>> 563e630463dddbbb43d52ef8c6eade0a97247e85
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor', 'id');
    }

<<<<<<< HEAD
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
=======
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
>>>>>>> 563e630463dddbbb43d52ef8c6eade0a97247e85
    }
}
