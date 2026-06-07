<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SppDisbursement extends Model
{
    use HasFactory;

    protected $table = 'spp_disbursements';
    protected $fillable = ['loan_id', 'tahap_ke', 'jumlah_cair', 'tanggal_cair', 'bukti_pencairan'];

    public function loan()
    {
        return $this->belongsTo(SppLoan::class, 'loan_id');
    }
}