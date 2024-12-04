<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan riwayat peminjaman pengguna.
     */
    public function indexRiwayat()
    {
        $peminjaman = Peminjaman::where('user_id', auth()->id())
                        ->with(['detailPeminjaman.barang', 'detailPeminjamanRuang.ruang'])
                        ->orderBy('tanggal_pinjam', 'desc')
                        ->paginate(5);

        return view('pengguna.peminjaman.index', compact('peminjaman'));
    }

    /**
     * Menampilkan detail peminjaman.
     */
    public function show($kode_pinjam)
    {
        $peminjaman = Peminjaman::with(['detailPeminjamanRuang.ruang', 'detailPeminjaman.barang'])
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
        return view('pengguna.peminjaman.create');
    }

    /**
     * Memproses pembuatan janji peminjaman.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pinjam' => [
                'required',
                'date',
                'after_or_equal:' . now()->addDays(7)->toDateString(),
            ],
            'tanggal_kembali' => [
                'required',
                'date',
                'after_or_equal:tanggal_pinjam',
            ],
        ]);

        $tanggalPinjam = $request->tanggal_pinjam;
        $tanggalKembali = $request->tanggal_kembali;

        session(['tanggal_pinjam' => $tanggalPinjam, 'tanggal_kembali' => $tanggalKembali]);

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
            'catatan' => 'Peminjaman',
        ]);

        return redirect()->route('detail.index')->with('success', 'Tambahkan barang ke keranjang');
    }

    /**
     * Mengajukan peminjaman.
     */
    public function cancel()
    {
        $existingLoan = Peminjaman::where('user_id', auth()->id())
                        ->where('status', 'Pending')
                        ->first();

        $existingLoan->delete();
                        
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman di Cancel');
    }

    /**
     * Mengajukan pengembalian.
     */
    public function kembalikan($kodePinjam)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman.barang', 'detailPeminjamanRuang.ruang')
                        ->where('kode_pinjam', $kodePinjam)
                        ->where('user_id', auth()->id())
                        ->where('status', 'Belum Selesai')
                        ->firstOrFail();

        $peminjaman->update(['status' => 'Pending', 'catatan' => 'Pengembalian']); // Pending untuk pengembalian

        return redirect()->route('peminjaman.index')->with('success', 'Pengembalian diajukan. Menunggu persetujuan admin.');
    }
}
