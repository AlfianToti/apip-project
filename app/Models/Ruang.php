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
    protected $keyType = 'string'; // Tipe primary key
    protected $fillable = ['kode_ruang', 'nama_ruang', 'status']; // Kolom yang dapat diisi
    public $timestamps = true; // Secara default, Laravel akan mengelola kolom created_at dan updated_at
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'kode_ruang');
    }
}

