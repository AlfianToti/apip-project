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
        // Ambil janji peminjaman pengguna yang sedang berlangsung
        $peminjaman = Peminjaman::where('user_id', auth()->id())
                        ->where('status', 'Belum Selesai')
                        ->first();

        // Jika tidak ada janji peminjaman, arahkan ke form pembuatan janji peminjaman
        if (!$peminjaman) {
            return redirect()->route('peminjaman.ruangan.index')->withErrors('Silakan buat peminjaman terlebih dahulu.');
        }

        // Barang yang sudah dipinjam dalam keranjang
        $barangDipinjam = $peminjaman->detailPeminjaman->load('barang');

        // Barang yang tersedia untuk dipinjam
        $barangTersedia = Barang::where('status', 'Tersedia')->get();

        // Kirim data ke view
        return view('pengguna.peminjaman.keranjang', compact('barangDipinjam', 'peminjaman', 'barangTersedia'));
    }


    /**
     * Menampilkan form untuk menambahkan barang ke keranjang.
     */
    public function create()
    {
        // Ambil semua barang yang tersedia untuk ditampilkan di form peminjaman
        $barang = Barang::where('status', 'Tersedia')->get();

        return view('pengguna.peminjaman.create', compact('barang'));
    }

    /**
     * Menambahkan barang ke keranjang peminjaman.
     */
    public function store(Request $request)
    {
        // Cek apakah pengguna memiliki janji peminjaman
        $peminjaman = Peminjaman::where('user_id', auth()->id())
                        ->where('status', 'Belum Selesai')
                        ->first();

        if (!$peminjaman) {
            return redirect()->route('peminjaman.ruangan.index')->withErrors('Silakan mengisi form peminjaman terlebih dahulu.');
        }

        // Validasi input barang dan ketersediaannya
        $request->validate([
            'kode_barang' => 'required|exists:barang,kode_barang',
        ]);

        $barang = Barang::where('kode_barang', $request->kode_barang)->where('status', 'Tersedia')->first();
        if (!$barang) {
            return redirect()->route('keranjang.index')->withErrors('Barang tidak tersedia untuk dipinjam.');
        }

        // Hitung jumlah detail peminjaman untuk janji ini
        $detailCount = DetailPeminjaman::where('kode_pinjam', $peminjaman->kode_pinjam)->count();
        $detailNumber = str_pad($detailCount + 1, 3, '0', STR_PAD_LEFT);

        // Buat kode_detail unik
        $kodeDetail = "DTL-{$peminjaman->kode_pinjam}-{$detailNumber}";

        // Tambahkan barang ke detail peminjaman
        DetailPeminjaman::firstOrCreate([
            'kode_detail' => $kodeDetail,
            'kode_pinjam' => $peminjaman->kode_pinjam,
            'kode_barang' => $request->kode_barang,
        ]);

        // Update status barang menjadi "Dipinjam"
        Barang::where('kode_barang', $request->kode_barang)->update(['status' => 'Dipinjam']);

        return redirect()->route('keranjang.index')->with('success', 'Barang berhasil ditambahkan ke keranjang.');
    }

    /**
     * Menghapus barang dari keranjang peminjaman.
     */
    public function remove($kode_detail)
    {
        $detail = DetailPeminjaman::where('kode_detail', $kode_detail)->first();

        if ($detail) {
            // Kembalikan status barang menjadi Tersedia
            Barang::where('kode_barang', $detail->kode_barang)->update(['status' => 'Tersedia']);

            // Hapus detail peminjaman
            $detail->delete();
        }

        return redirect()->route('keranjang.index')->with('success', 'Barang berhasil dihapus dari keranjang');
    }

    /**
     * Mengajukan peminjaman semua barang di keranjang.
     */
    public function submit()
    {
        // Ambil peminjaman yang sedang berlangsung
        $peminjaman = Peminjaman::where('user_id', auth()->id())
                        ->where('status', 'Belum Selesai')
                        ->first();

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diajukan');
    }
}
