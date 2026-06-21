<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'tanggal_dikembalikan',
        'status_rental',
        'status_pembayaran',
        'bukti_pembayaran',
        'total_sewa',
        'total_denda',
        'alamat',
        'sewa_driver',
        'is_dp',
        'is_sewa_perbulan',
        'bukti_dp',
        'berapa_bulan',
        'customer_id',
        'vehicle_id',
        'file_identitas'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
