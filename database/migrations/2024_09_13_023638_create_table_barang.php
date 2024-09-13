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
        Schema::create('barang', function (Blueprint $table) {
            $table->bigIncrements('kode_barang');
            $table->string('nama');
            $table->boolean('status')->default(true); // true untuk 'tersedia', false untuk 'tidak'
            $table->unsignedBigInteger('kode_ruang')->nullable();

            $table->foreign('kode_ruang')->references('kode_ruang')->on('ruang')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
