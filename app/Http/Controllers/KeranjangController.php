<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;

class KeranjangController extends Controller
{
    /**
     * Menampilkan keranjang peminjaman barang.
     */
    public function index()
    {
        $peminjaman = Peminjaman::where('user_id', auth()->id())
                        ->where('status', 'Pending')
                        ->first();

        if (!$peminjaman) {
            return redirect()->route('peminjaman.ruangan.index')->withErrors('Silakan buat peminjaman terlebih dahulu.');
        }

        // Barang yang sudah ada di keranjang
        $barangDipinjam = $peminjaman->detailPeminjaman->load('barang');

        // Ambil barang yang tersedia dan belum ada di keranjang
        $barangTersedia = Barang::where('status', 'Tersedia')
                                ->whereNotIn('kode_barang', $barangDipinjam->pluck('barang.kode_barang'))
                                ->get();

        return view('pengguna.peminjaman.keranjang', compact('barangDipinjam', 'peminjaman', 'barangTersedia'));
    }


    /**
     * Menambahkan barang ke keranjang peminjaman.
     */
    public function store(Request $request)
    {
        $peminjaman = Peminjaman::where('user_id', auth()->id())
                        ->where('status', 'Pending')
                        ->first();

        if (!$peminjaman) {
            return redirect()->route('peminjaman.ruangan.index')->withErrors('Silakan mengisi form peminjaman terlebih dahulu.');
        }

        $request->validate([
            'kode_barang' => 'required|exists:barang,kode_barang',
        ]);

        $barang = Barang::where('kode_barang', $request->kode_barang)
                        ->where('status', 'Tersedia')
                        ->first();

        if (!$barang) {
            return redirect()->route('keranjang.index')->withErrors('Barang tidak tersedia untuk dipinjam.');
        }

        $detailCount = DetailPeminjaman::where('kode_pinjam', $peminjaman->kode_pinjam)->count();
        $detailNumber = str_pad($detailCount + 1, 3, '0', STR_PAD_LEFT);

        $kodeDetail = "DTL-{$peminjaman->kode_pinjam}-{$detailNumber}";

        DetailPeminjaman::create([
            'kode_detail' => $kodeDetail,
            'kode_pinjam' => $peminjaman->kode_pinjam,
            'kode_barang' => $request->kode_barang,
        ]);

        return redirect()->route('keranjang.index')->with('success', 'Barang berhasil ditambahkan ke keranjang.');
    }

    /**
     * Menghapus barang dari keranjang peminjaman.
     */
    public function remove($kode_detail)
    {
        $detail = DetailPeminjaman::where('kode_detail', $kode_detail)->first();

        if ($detail) {
            $detail->delete();
        }

        return redirect()->route('keranjang.index')->with('success', 'Barang berhasil dihapus dari keranjang.');
    }

    public function submit()
    {
        // Ambil peminjaman yang sedang berlangsung
        $peminjaman = Peminjaman::where('user_id', auth()->id())
                        ->where('status', 'Pending')
                        ->where('catatan', 'Peminjaman')
                        ->first();

        if (!$peminjaman) {
            return redirect()->route('keranjang.index')->withErrors('Tidak ada peminjaman yang sedang berlangsung.');
        }

        // Update status peminjaman menjadi "Pending"
        $peminjaman->update(['status' => 'Pending', 'catatan' => 'Peminjaman']);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diajukan. Menunggu persetujuan admin.');
    }

}
