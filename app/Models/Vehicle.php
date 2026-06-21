<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_plat',
        'merek',
        'tahun',
        'warna',
        'harga_perhari',
        'denda_perhari',
        'harga_perbulan',
        'sewa_driver',
        'gambar',
        'is_ready',
    ];
}
