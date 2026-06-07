<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. TABEL KELOMPOK (spp_groups)
        Schema::create('spp_groups', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelompok');
            $table->string('nama_ketua');
            $table->string('no_hp_ketua', 15);
            $table->text('alamat_kelompok');
            $table->enum('status', ['aktif', 'non_aktif'])->default('aktif');
            $table->timestamps();
        });

        // 2. TABEL ANGGOTA KELOMPOK (spp_members)
        Schema::create('spp_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('spp_groups')->onDelete('cascade');
            $table->string('nik', 16)->unique();
            $table->string('nama_anggota');
            $table->string('file_ktp');
            $table->timestamps();
        });

        // 3. TABEL TRANSAKSI PINJAMAN (spp_loans)
        Schema::create('spp_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('spp_groups')->onDelete('cascade');
            $table->string('no_kontrak')->unique();
            $table->decimal('plafon_disetujui', 12, 2);
            $table->decimal('total_dicairkan', 12, 2)->default(0);
            $table->float('bunga_persen')->default(0.5);
            $table->integer('tenor_bulan');
            $table->enum('status_loan', ['review', 'berjalan', 'macet', 'lunas'])->default('review');
            $table->timestamps();
        });

        // 4. TABEL RIWAYAT PENCAIRAN DANA (spp_disbursements)
        Schema::create('spp_disbursements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained('spp_loans')->onDelete('cascade');
            $table->integer('tahap_ke');
            $table->decimal('jumlah_cair', 12, 2);
            $table->date('tanggal_cair');
            $table->string('bukti_pencairan')->nullable();
            $table->timestamps();
        });

        // 5. TABEL ANGSURAN BULANAN (spp_installments)
        Schema::create('spp_installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained('spp_loans')->onDelete('cascade');
            $table->integer('angsuran_ke');
            $table->decimal('jumlah_pokok', 12, 2);
            $table->decimal('jumlah_bunga', 12, 2);
            $table->date('tanggal_jatuh_tempo');
            $table->date('tanggal_bayar')->nullable();
            $table->decimal('denda_kumulatif', 12, 2)->default(0);
            $table->enum('status_bayar', ['belum_bayar', 'lunas', 'terlambat'])->default('belum_bayar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spp_installments');
        Schema::dropIfExists('spp_disbursements');
        Schema::dropIfExists('spp_loans');
        Schema::dropIfExists('spp_members');
        Schema::dropIfExists('spp_groups');
    }
};