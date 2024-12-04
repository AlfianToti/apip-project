<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailPeminjaman;
use App\Models\DetailPeminjamanRuang;
use App\Models\Peminjaman;
use App\Models\Ruang;
use Illuminate\Http\Request;

class AdminPeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['detailPeminjamanRuang.ruang', 'detailPeminjaman.barang'])
                        ->where('status', 'Pending')
                        ->where('catatan', 'Peminjaman')
                        ->get();

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function approve($kodePinjam)
    {
        $peminjaman = Peminjaman::where('kode_pinjam', $kodePinjam)
                        ->where('status', 'Pending')
                        ->firstOrFail();

        $peminjaman->update(['status' => 'Belum Selesai']);

         // Update Detail Peminjaman Ruang menggunakan perulangan
         $detailPeminjamanRuang = DetailPeminjamanRuang::where('kode_pinjam', $kodePinjam)->get();
         foreach ($detailPeminjamanRuang as $detail) {

            // Ambil tanggal_req_pinjam dan tanggal_req_kembali dari DetailPeminjamanRuang
            $tanggalPinjam = $detail->tanggal_req_pinjam;
            $tanggalKembali = $detail->tanggal_req_kembali;

            $detail->update([
                 'tanggal_pinjam_ruang' => $tanggalPinjam,
                 'tanggal_kembali_ruang' => $tanggalKembali,
            ]);
         }

         // Update Detail Peminjaman menggunakan perulangan
         $detailPeminjaman = DetailPeminjaman::where('kode_pinjam', $kodePinjam)->get();
         foreach ($detailPeminjaman as $detail) {

            // Ambil tanggal_req_pinjam dan tanggal_req_kembali dari DetailPeminjamanRuang
            $tanggalPinjam = $detail->tanggal_req_pinjam;
            $tanggalKembali = $detail->tanggal_req_kembali;

            $detail->update([
                 'tanggal_pinjam_barang' => $tanggalPinjam,
                 'tanggal_kembali_barang' => $tanggalKembali,
            ]);
         }
         
        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil disetujui.');
    }
        // (kode untuk function diatas) Panggil fungsi untuk update status barang dan ruang
        // $this->updateStatusBarangRuang($peminjaman);

    // public function updateStatusBarangRuang(Peminjaman $peminjaman)
    // {
    //     $hariIni = now();  // Ambil tanggal sekarang

    //     // Pastikan peminjaman berada dalam rentang waktu yang valid
    //     if ($hariIni->greaterThanOrEqualTo($peminjaman->tanggal_req_pinjam)) {
    //         // Update status barang yang dipinjam menjadi "Dipinjam"
    //         foreach ($peminjaman->detailPeminjaman as $detail) {
    //             if ($detail->kode_barang) {
    //                 $barang = Barang::where('kode_barang', $detail->kode_barang)->first();
    //                 if ($barang && $barang->status == 'Tersedia') {
    //                     $barang->update(['status' => 'Dipinjam']);
    //                 }
    //             }
    //          }

    //         foreach ($peminjaman->detailPeminjaman as $detail) {
    //             if ($detail->kode_ruang) {
    //                 $ruang = Ruang::where('kode_ruang', $detail->kode_ruang)->first();
    //                 if ($ruang && $ruang->status == 'Tersedia') {
    //                     $ruang->update(['status' => 'Dipinjam']);
    //                 }
    //             }
    //         }
    //     }
    // }

    public function reject($kodePinjam)
    {
        $peminjaman = Peminjaman::where('kode_pinjam', $kodePinjam)->firstOrFail();

        $peminjaman->update(['status' => 'Canceled']);

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil ditolak.');
    }

    public function indexPengembalian()
    {
        $peminjaman = Peminjaman::with(['detailPeminjamanRuang.ruang', 'detailPeminjaman.barang'])
                        ->where('status', 'Pending')
                        ->where('catatan', 'Pengembalian')
                        ->get();

        return view('admin.peminjaman.pengembalian', compact('peminjaman'));
    }

    public function approvePengembalian($kodePinjam)
    {
        // Ambil data peminjaman berdasarkan kode_pinjam
        $peminjaman = Peminjaman::where('kode_pinjam', $kodePinjam)
                                ->where('status', 'Pending')
                                ->where('catatan', 'Pengembalian')
                                ->first();

        if (!$peminjaman) {
            return redirect()->route('admin.peminjaman.pengembalian')->withErrors('Peminjaman tidak ditemukan.');
        }

        // Proses update status peminjaman menjadi 'Selesai'
        $peminjaman->update(['status' => 'Selesai', 'tanggal_kembali' => now()]);

        // Update Detail Peminjaman Ruang menggunakan perulangan
        $detailPeminjamanRuang = DetailPeminjamanRuang::where('kode_pinjam', $kodePinjam)->get();
        foreach ($detailPeminjamanRuang as $detail) {

           $detail->update([
                'tanggal_pinjam_ruang' => null,
                'tanggal_kembali_ruang' => null,
           ]);
        }

        // Update Detail Peminjaman menggunakan perulangan
        $detailPeminjaman = DetailPeminjaman::where('kode_pinjam', $kodePinjam)->get();
        foreach ($detailPeminjaman as $detail) {

           $detail->update([
                'tanggal_pinjam_barang' => null,
                'tanggal_kembali_barang' => null,
           ]);
        }

        // Kembalikan respons sukses
        return redirect()->route('admin.peminjaman.pengembalian')->with('success', 'Pengembalian berhasil diproses.');
    }

    public function rejectPengembalian($kodePinjam)
    {
        $peminjaman = Peminjaman::where('kode_pinjam', $kodePinjam)->firstOrFail();

        $peminjaman->update(['status' => 'Belum Selesai']);

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil ditolak.');
    }

    public function laporan(Request $request)
    {
        $query = Peminjaman::with(['detailPeminjamanRuang.ruang', 'detailPeminjaman.barang', 'user']);

        // Filter berdasarkan tanggal (opsional)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_pinjam', [$request->start_date, $request->end_date]);
        }

        // Filter berdasarkan status (opsional)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->orderBy('tanggal_pinjam', 'desc')->get();

        return view('admin.peminjaman.laporan', compact('peminjaman'));
    }

}
