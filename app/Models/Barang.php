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

    // Kolom yang bisa diisi secara massal
    protected $fillable = ['nama', 'status'];

    // Secara default, Laravel akan mengelola kolom created_at dan updated_at
    public $timestamps = true;
}
