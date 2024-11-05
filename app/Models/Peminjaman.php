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

    // Kolom yang dapat diisi (mass assignment)
    protected $fillable = [
        'user_id',
        'barang_id',
        'ruang_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'catatan',
    ];

    // Jika primary key bukan increment integer bawaan Laravel
    public $incrementing = true;
    protected $keyType = 'bigint';

    // Relasi jika ada
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function ruang()
    {
        return $this->belongsTo(Ruang::class);
    }
}
