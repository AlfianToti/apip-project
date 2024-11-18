<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Ruang;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan riwayat peminjaman pengguna.
     */
    public function indexRiwayat()
    {
        $peminjaman = Peminjaman::where('user_id', auth()->id())
                        ->with(['detailPeminjaman.barang', 'ruang'])
                        ->orderBy('tanggal_pinjam', 'desc')
                        ->paginate(5);

        return view('pengguna.peminjaman.index', compact('peminjaman'));
    }

    /**
     * Menampilkan detail peminjaman.
     */
    public function show($kode_pinjam)
    {
        $peminjaman = Peminjaman::with(['ruang', 'detailPeminjaman.barang'])
                        ->where('kode_pinjam', $kode_pinjam)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        return view('pengguna.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Menampilkan form untuk membuat janji peminjaman.
     */
    public function indexPeminjaman()
    {
        $ruang = Ruang::where('status', 'Tersedia')->get();

        return view('pengguna.peminjaman.create', compact('ruang'));
    }

    /**
     * Memproses pembuatan janji peminjaman.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_ruang' => 'nullable|exists:ruang,kode_ruang',
        ]);

        $existingLoan = Peminjaman::where('user_id', auth()->id())
                        ->whereIn('status', ['Belum Selesai', 'Pending'])
                        ->first();

        if ($existingLoan) {
            return redirect()->route('peminjaman.index')
                ->withErrors('Anda tidak bisa membuat peminjaman baru karena masih ada peminjaman yang belum selesai.');
        }

        $kodePinjam = 'PJM-' . auth()->id() . '-' . now()->format('YmdHis');

        Peminjaman::create([
            'kode_pinjam' => $kodePinjam,
            'user_id' => auth()->id(),
            'tanggal_pinjam' => now(),
            'status' => 'Pending',
            'kode_ruang' => $request->kode_ruang,
            'catatan' => 'Peminjaman',
        ]);

        return redirect()->route('keranjang.index')->with('success', 'Janji peminjaman berhasil dibuat. Tambahkan barang ke keranjang.');
    }

    /**
     * Mengajukan peminjaman.
     */
    public function submit($kodePinjam)
    {
        $peminjaman = Peminjaman::where('kode_pinjam', $kodePinjam)
                        ->where('user_id', auth()->id())
                        ->where('status', 'Pending')
                        ->firstOrFail();

        $peminjaman->update(['status' => 'Pending']);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diajukan. Menunggu persetujuan admin.');
    }

    /**
     * Mengajukan pengembalian.
     */
    public function kembalikan($kodePinjam)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman.barang', 'ruang')
                        ->where('kode_pinjam', $kodePinjam)
                        ->where('user_id', auth()->id())
                        ->where('status', 'Belum Selesai')
                        ->firstOrFail();

        $peminjaman->update(['status' => 'Pending', 'catatan' => 'Pengembalian']); // Pending untuk pengembalian

        return redirect()->route('peminjaman.index')->with('success', 'Pengembalian diajukan. Menunggu persetujuan admin.');
    }
}
