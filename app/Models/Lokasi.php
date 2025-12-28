<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $table = 'lokasis';

    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'alamat',
    ];
}
