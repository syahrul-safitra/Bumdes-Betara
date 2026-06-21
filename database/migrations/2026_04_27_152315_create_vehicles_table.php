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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            $table->string('no_plat')->unique();

            $table->string('merek');

            $table->string('warna');
            $table->string('tahun', 4);
            $table->integer('harga_perhari')->unsigned();
            $table->integer('denda_perhari')->unsigned();
            $table->string('gambar');
            $table->integer('harga_perbulan')->unsigned();
            $table->boolean('is_ready')->default("1");
            $table->integer('sewa_driver');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
