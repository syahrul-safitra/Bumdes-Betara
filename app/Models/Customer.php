<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Customer extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nama', 
        'tipe',
        'email',
        // 'alamat',
        'no_telepon', 
        'file_identitas', 
        'password'
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function rental() {
        return $this->hasMany(Rental::class);
    }

}
