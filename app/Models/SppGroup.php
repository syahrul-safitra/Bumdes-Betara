<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SppGroup extends Model
{
    use HasFactory;

    protected $table = 'spp_groups';
    protected $fillable = ['nama_kelompok', 'nama_ketua', 'no_hp_ketua', 'alamat_kelompok', 'status', 'nik_ketua', 'file_ktp'];

    // Relasi: Satu kelompok memiliki banyak anggota
    public function members()
    {
        return $this->hasMany(SppMember::class, 'group_id');
    }

    // Relasi: Satu kelompok bisa memiliki beberapa riwayat pinjaman
    public function loans()
    {
        return $this->hasMany(SppLoan::class, 'group_id');
    }

}