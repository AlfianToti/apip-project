<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjamanRuang extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda dari nama model
    protected $table = 'detail_peminjaman_ruang';

    // Primary key dari tabel
    protected $primaryKey = 'kode_detail_ruang';

    // Tipe primary key
    protected $keyType = 'string';

    // Kolom yang dapat diisi (mass assignment)
    protected $fillable = [
        'kode_detail_ruang',
        'kode_pinjam',
        'tanggal_req_pinjam',
        'tanggal_req_kembali',
        'tanggal_pinjam_ruang',
        'tanggal_kembali_ruang',
        'kode_ruang'
    ];

    // Relasi jika ada
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'kode_pinjam', 'kode_pinjam');
    }
    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'kode_ruang', 'kode_ruang');
    }



}
