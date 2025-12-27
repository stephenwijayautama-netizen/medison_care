<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute; // Opsional, untuk Accessor modern

class Product extends Model
{
    // 1. FILLABLE: Daftar kolom yang boleh diisi user
    protected $fillable = [
        'category_id',
        'created_by',
        'product_name', // Nama asli di database
        'description',
        'price',
        'stock',
        'image',
        
        // Tambahan PENTING untuk logika Frontend:
        'promo_price', // Harga coret
        'promo',       // Status promo (1/0)
        'best_seller', // Status terlaris (1/0)
    ];

    // 2. CASTS: Mengubah tipe data otomatis saat diambil dari DB
    protected $casts = [
        'promo' => 'boolean',       // 1 jadi true, 0 jadi false
        'best_seller' => 'boolean', // 1 jadi true, 0 jadi false
        'price' => 'integer',       // Memastikan harga jadi angka
        'promo_price' => 'integer',
        'created_at' => 'datetime',
    ];

    // 3. ACCESSOR: Agar di Blade bisa panggil $item->name (padahal di DB product_name)
    // Ini menjaga konsistensi dengan kode Blade yang sudah kita buat ($item->name)
    public function getNameAttribute()
    {
        return $this->product_name;
    }

    // --- RELATIONSHIPS ---

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke User pembuat (Creator)
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Jika kamu tetap ingin menggunakan nama fungsi 'user'
    public function user(): BelongsTo
    {
        return $this->creator(); // Alias ke creator saja biar rapi
    }
}