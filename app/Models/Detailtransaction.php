<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <--- Import ini

class Detailtransaction extends Model
{
    // Tips: Jika nama tabelmu bukan 'detailtransactions', definisikan di sini
    // protected $table = 'detail_transactions'; 

    protected $fillable = [
        'transaction_id',
        'product_id',
        'product_name',
        'quantity',
        'price',
        'subtotal',
    ];

    // Relasi ke Transaction (Induk)
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    // Bonus: Relasi ke Product (Jika kamu punya model Product)
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}