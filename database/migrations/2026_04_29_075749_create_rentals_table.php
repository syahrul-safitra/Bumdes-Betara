<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();

            $table->date('tanggal_peminjaman');
            $table->date('tanggal_pengembalian');
            $table->date('tanggal_dikembalikan')->nullable();

            $table->enum('status_rental', ['belum_diambil', 'sedang_dipinjam', 'telah_dikembalikan'])->default('belum_diambil');

            $table->enum('status_pembayaran', ['pending', 'telah_dibayar'])->default('pending');

            $table->string('bukti_pembayaran')->nullable();

            $table->integer('total_denda')->default(0);
            $table->integer('total_sewa')->default(0);

            $table->foreignId('customer_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();

            $table->string('file_identitas')->nullable();
            $table->string('alamat')->nullable();

            $table->boolean('sewa_driver');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
