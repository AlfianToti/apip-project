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
    public function index(Request $request)
    {
        $peminjaman = Peminjaman::where('user_id', auth()->id())
                                ->where('status', 'Pending')
                                ->first();

        // Mengambil tanggal pinjam dan tanggal kembali dari session
        $tanggalPinjam = session('tanggal_pinjam');
        $tanggalKembali = session('tanggal_kembali');

        // Ambil barang dan ruang yang sudah ada di keranjang
        $barangDipinjam = $peminjaman->detailPeminjaman->load('barang');

        // Filter barang dan ruang yang tersedia berdasarkan rentang waktu yang dipilih
        $barangTersedia = Barang::whereNotIn('kode_barang', $barangDipinjam->pluck('barang.kode_barang'))
                                ->whereDoesntHave('detailPeminjaman', function ($query) use ($tanggalPinjam, $tanggalKembali) {
                                    // Saring ruang yang memiliki peminjaman dalam rentang waktu yang diminta
                                    $query->where(function ($subQuery) use ($tanggalPinjam, $tanggalKembali) {
                                        $subQuery->whereBetween('tanggal_pinjam_barang', [$tanggalPinjam, $tanggalKembali])
                                                ->orWhere(function ($subSubQuery) use ($tanggalPinjam, $tanggalKembali) {
                                                    $subSubQuery->where('tanggal_kembali_barang', '>=', $tanggalPinjam)
                                                                ->where('tanggal_kembali_barang', '<=', $tanggalKembali);
                                                });
                                    });
                                })
                                ->select('kode_barang', 'nama_barang') // Ambil hanya kolom yang dibutuhkan
                                ->orderBy('nama_barang', 'asc')
                                ->paginate(5);

        return view('pengguna.peminjaman.keranjangb', compact('barangDipinjam', 'peminjaman', 'barangTersedia',));
    }

    /**
     * Menambahkan barang ke keranjang peminjaman.
     */

    public function store(Request $request)
    {
        // Ambil peminjaman yang sedang berlangsung
        $peminjaman = Peminjaman::where('user_id', auth()->id())
                                ->where('status', 'Pending')
                                ->first();

        // Validasi inputan
        $request->validate([
            'kode_barang' => 'required|exists:barang,kode_barang',
        ]);  

        $tanggalPinjam = session('tanggal_pinjam');
        $tanggalKembali = session('tanggal_kembali');

        // Periksa apakah barang/ruang yang dipilih tersedia dalam rentang waktu
        if ($request->kode_barang) {
            $barang = Barang::where('kode_barang', $request->kode_barang)->first();
            $barangDipinjam = $barang->detailPeminjaman->whereBetween('tanggal_pinjam_barang', [$tanggalPinjam, $tanggalKembali])->count();
            if ($barangDipinjam > 0) {
                return redirect()->route('keranjang.index')->withErrors('Barang sudah dipinjam dalam rentang waktu ini.');
            }
        } else {
            return redirect()->route('keranjang.index')->withErrors('Silakan pilih barang untuk dipinjam.');
        }

        // Generate kode detail peminjaman
        $detailCount = DetailPeminjaman::where('kode_pinjam', $peminjaman->kode_pinjam)->count();
        $detailNumber = str_pad($detailCount + 1, 3, '0', STR_PAD_LEFT);
        $kodeDetail = "DT-B-{$peminjaman->kode_pinjam}-{$detailNumber}";

        // Menyimpan detail peminjaman (baik barang atau ruang, atau keduanya)
        DetailPeminjaman::create([
            'kode_detail' => $kodeDetail,
            'kode_pinjam' => $peminjaman->kode_pinjam,
            'kode_barang' => $request->kode_barang,
            'tanggal_req_pinjam' => $tanggalPinjam,
            'tanggal_req_kembali' => $tanggalKembali,
        ]);

        return redirect()->route('keranjang.index')->with('success', 'Peminjaman berhasil ditambahkan ke keranjang.');
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

        return redirect()->route('keranjang.index')->with('success', 'Peminjaman berhasil dihapus dari keranjang.');
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

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diajukan. Menunggu persetujuan admin.');
    }

}
