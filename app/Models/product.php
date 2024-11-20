<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',                
        'description',    
        'image URL',   
        'stock_left',
        'buy_price',   
        'sell_price',  
    ];
}
