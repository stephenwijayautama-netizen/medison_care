<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $guarded = ['id']; // Izinkan semua kolom diisi
    protected $fillable = 
    [
        'transaction_id',
        'courier_id',
        'delivery_address',
        'status',
        'shipped_at',
        'delivered_at',
        'notes',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    
    // Relasi ke Courier (Asumsi Anda punya model Courier)
    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }
}
