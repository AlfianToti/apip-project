<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda dari nama model
    protected $table = 'peminjaman';

    // Primary key dari tabel
    protected $primaryKey = 'kode_pinjam';
    
    // Tipe primary key
    protected $keyType = 'string';

    // Kolom yang dapat diisi (mass assignment)
    protected $fillable = [
        'kode_pinjam',
        'user_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'catatan',
        'status',
    ];
    // Relasi jika ada
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'kode_pinjam', 'kode_pinjam');
    }
    public function detailPeminjamanRuang()
    {
        return $this->hasMany(DetailPeminjamanRuang::class, 'kode_pinjam', 'kode_pinjam');
    }
}
