<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Roster extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'supervisor_id',
        'doctor_id',
        'caregiver1',
        'caregiver2',
        'caregiver3',
        'caregiver4',
    ];

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
    
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
    
    public function caregiver1()
    {
        return $this->belongsTo(User::class, 'caregiver1');
    }
    
    public function caregiver2()
    {
        return $this->belongsTo(User::class, 'caregiver2');
    }
    
    public function caregiver3()
    {
        return $this->belongsTo(User::class, 'caregiver3');
    }
    
    public function caregiver4()
    {
        return $this->belongsTo(User::class, 'caregiver4');
    }
}