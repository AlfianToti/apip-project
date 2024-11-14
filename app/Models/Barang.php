<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'barang';

    // Primary key dari tabel barang
    protected $primaryKey = 'kode_barang';

    // Tipe primary key
    protected $keyType = 'string'; 

    // Kolom yang bisa diisi
    protected $fillable = ['kode_barang', 'nama_barang', 'status'];

    // Secara default, Laravel akan mengelola kolom created_at dan updated_at
    public $timestamps = true;
    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'kode_barang');
    }
}
