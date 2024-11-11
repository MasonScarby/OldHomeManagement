<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class movies extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',           
        'director',       
        'description',    
        'release_date',   
        'number_of_ratings',
        'average_rating',   
    ];
}
