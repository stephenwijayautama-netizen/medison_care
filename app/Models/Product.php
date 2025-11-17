<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'category_id',
        'created_by',
        'producrt_name',
        'description',
        'price',
        'stock',
        'created_at',
    ];
}
