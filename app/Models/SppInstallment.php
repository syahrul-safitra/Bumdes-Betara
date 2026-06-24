<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SppInstallment extends Model
{
    use HasFactory;

    protected $table = 'spp_installments';
    protected $fillable = ['loan_id', 'angsuran_ke', 'jumlah_pokok', 'jumlah_bunga', 'tanggal_jatuh_tempo', 'tanggal_bayar', 'denda_kumulatif', 'status_bayar', 'bukti_pembayaran', 'waktu_bayar'];

    public function loan()
    {
        return $this->belongsTo(SppLoan::class, 'loan_id');
    }
}