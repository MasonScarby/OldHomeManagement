<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    // Specify the attributes that can be mass-assigned
    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'is_approved',
    ];

    // Specify relationships, e.g., if User has a role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
