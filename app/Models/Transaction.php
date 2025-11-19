<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class); 
    }
}
