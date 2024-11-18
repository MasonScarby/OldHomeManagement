<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employees extends Model
{
    use HasFactory;
    protected $fillable = [
        'role',
        'salary',
        'user_id',
        'employee_id'
    ];
}
