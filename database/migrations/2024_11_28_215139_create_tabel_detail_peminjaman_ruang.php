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
        Schema::create('detail_peminjaman_ruang', function (Blueprint $table) {
            $table->string('kode_detail_ruang')->primary();
            $table->string('kode_pinjam'); 
            $table->date('tanggal_req_pinjam');
            $table->date('tanggal_req_kembali');
            $table->date('tanggal_pinjam_ruang')->nullable();
            $table->date('tanggal_kembali_ruang')->nullable();
            $table->string('kode_ruang');
            $table->timestamps();

            $table->foreign('kode_pinjam')->references('kode_pinjam')->on('peminjaman')->onDelete('cascade');
            $table->foreign('kode_ruang')->references('kode_ruang')->on('ruang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjaman_ruang');
    }
};
