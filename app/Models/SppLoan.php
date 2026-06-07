<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SppLoan extends Model
{
    use HasFactory;

    protected $table = 'spp_loans';
    protected $fillable = ['group_id', 'no_kontrak', 'plafon_disetujui', 'total_dicairkan', 'bunga_persen', 'tenor_bulan', 'status_loan'];

    public function group()
    {
        return $this->belongsTo(SppGroup::class, 'group_id');
    }

    // Relasi: Satu pinjaman memiliki beberapa tahap pencairan
    public function disbursements()
    {
        return $this->hasMany(SppDisbursement::class, 'loan_id');
    }

    // Relasi: Satu pinjaman memiliki banyak baris angsuran bulanan
    public function installments()
    {
        return $this->hasMany(SppInstallment::class, 'loan_id');
    }
}