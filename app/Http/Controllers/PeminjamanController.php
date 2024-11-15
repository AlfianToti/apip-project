<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Ruang;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan riwayat peminjaman pengguna.
     */
    public function indexRiwayat()
    {
        // Ambil semua riwayat peminjaman pengguna
        $peminjaman = Peminjaman::where('user_id', auth()->id())->orderBy('tanggal_pinjam', 'desc')->get();

        return view('pengguna.peminjaman.index', compact('peminjaman'));
    }

    /**
     * Menampilkan detail peminjaman.
     */
    public function show($kode_pinjam)
    {
        $peminjaman = Peminjaman::where('kode_pinjam', $kode_pinjam)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        return view('pengguna.peminjaman.show', compact('peminjaman'));
    }
    /**
     * Memproses pembuatan janji peminjaman.
     */
    public function indexPeminjaman()
    {
        // Ambil semua ruangan yang tersedia untuk ditampilkan (opsional)
        $ruang = Ruang::where('status', 'Tersedia')->get();

        return view('pengguna.peminjaman.create', compact('ruang'));
    }

    /**
     * Memproses pembuatan janji peminjaman dengan ruangan (opsional).
     */
    public function store(Request $request)
    {
        // Cek apakah pengguna memiliki peminjaman aktif
        $existingLoan = Peminjaman::where('user_id', auth()->id())
                        ->where('status', 'Belum Selesai')
                        ->first();

        if ($existingLoan) {
            return redirect()->route('peminjaman.ruangan.index')
                ->withErrors('Anda tidak bisa membuat janji peminjaman baru karena masih ada peminjaman yang belum selesai.');
        }

        // Validasi input ruangan (jika ada ruangan yang ingin dipinjam)
        $request->validate([
            'kode_ruang' => 'nullable|exists:ruang,kode_ruang',
        ]);

        // Ambil nama pengguna dan format agar tidak ada spasi atau karakter khusus
        $username = preg_replace('/\s+/', '', auth()->user()->name); // Menghapus spasi pada nama pengguna

        // Buat entri peminjaman
        $kodePinjam = 'PJM-' . $username . '-' . now()->format('YmdHis');
        Peminjaman::create([
            'kode_pinjam' => $kodePinjam,
            'user_id' => auth()->id(),
            'tanggal_pinjam' => now(),
            'status' => 'Belum Selesai',
            'ruang_id' => $request->kode_ruang, // Bisa null jika tidak memilih ruangan
        ]);

        // Jika ada ruangan, update statusnya menjadi "Dipinjam"
        if ($request->kode_ruang) {
            Ruang::where('kode_ruang', $request->kode_ruang)->update(['status' => 'Dipinjam']);
        }

        return redirect()->route('keranjang.index')->with('success', 'Janji peminjaman berhasil dibuat.');
    }
}
