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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->bigIncrements('kode_pinjam');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('barang_id')->nullable(); 
            $table->unsignedBigInteger('ruang_id')->nullable(); 
            $table->dateTime('tanggal_pinjam');
            $table->dateTime('tanggal_kembali')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('user_id')->references('id')->on('pengguna')->onDelete('cascade');
            $table->foreign('barang_id')->references('kode_barang')->on('barang')->onDelete('set null');
            $table->foreign('ruang_id')->references('kode_ruang')->on('ruang')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
