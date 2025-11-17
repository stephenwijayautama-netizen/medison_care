<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'shipping_cost',
        'status',
        'payment_method',
        'transaction_date',
    ];
}
