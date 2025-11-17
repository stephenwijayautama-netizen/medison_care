<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = 
    [
        'transaction_id',
        'courier_id',
        'tracling_number',
        'delivery_address',
        'status',
        'shipped_at',
        'delivered_at',
        'notes',
    ];
}
