<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $guarded = ['id'];
    protected $fillable = 
    [
        'name',
        'phone',
        'address',
    ];
}
