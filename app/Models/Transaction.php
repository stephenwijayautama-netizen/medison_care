<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // <--- Jangan lupa import ini

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'invoice_number', // <--- WAJIB ADA
        'total_amount',
        'shipping_cost',
        'status',
        'payment_method',
        'payment_url',    // <--- WAJIB ADA
        'transaction_date'
    ];
    protected $casts = [
        'transaction_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Tambahkan ini
    public function detailTransactions(): HasMany
    {
        return $this->hasMany(Detailtransaction::class);
    }

    public function delivery()
    {
    // hasOne karena 1 Transaksi biasanya hanya 1 Pengiriman
    return $this->hasOne(Delivery::class);
    }
}