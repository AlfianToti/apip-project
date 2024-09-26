<?php

// app/Models/Ruang.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    use HasFactory;

    protected $table = 'ruang'; // Nama tabel
    protected $primaryKey = 'kode_ruang'; // Primary key yang digunakan
    public $incrementing = false; // Non-auto increment jika kode_ruang bukan tipe integer auto-increment
    protected $keyType = 'string'; // Tipe primary key (misalnya string jika bukan integer)

    protected $fillable = ['kode_ruang', 'nama_ruang', 'status']; // Kolom yang dapat diisi
}

