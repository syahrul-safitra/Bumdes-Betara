<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SppMember extends Model
{
    use HasFactory;

    protected $table = 'spp_members';
    protected $fillable = ['group_id', 'nik', 'nama_anggota', 'file_ktp'];

    // Relasi: Anggota termasuk dalam suatu kelompok
    public function group()
    {
        return $this->belongsTo(SppGroup::class, 'group_id');
    }
}