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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); 
            $table->string('nama'); // Nama pengguna
            $table->string('email')->unique(); // Email pengguna, harus unik
            $table->string('password'); // Password pengguna
            $table->enum('role', ['admin', 'manager', 'user']); // Role pengguna
            $table->rememberToken(); // Token untuk 'remember me'
            $table->timestamps(); // Kolom untuk timestamp created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
