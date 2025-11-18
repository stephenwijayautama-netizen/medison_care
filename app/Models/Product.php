<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'category_id',
        'created_by',
        'product_name',
        'description',
        'price',
        'stock',
        'created_at',
        'image',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function creator(): BelongsTo
    {
        // Parameter 2 ('created_by') adalah nama kolom foreign key di tabel products
        return $this->belongsTo(User::class, 'created_by');
    }
}
