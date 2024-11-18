<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class AdminPeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['ruang', 'detailPeminjaman.barang'])
                        ->where('status', 'Pending')
                        ->where('catatan', 'Peminjaman')
                        ->get();

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function approve($kodePinjam)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman.barang', 'ruang')
                        ->where('kode_pinjam', $kodePinjam)
                        ->where('status', 'Pending')
                        ->firstOrFail();

        $peminjaman->update(['status' => 'Belum Selesai']);

        foreach ($peminjaman->detailPeminjaman as $detail) {
            $detail->barang->update(['status' => 'Dipinjam']);
        }

        if ($peminjaman->ruang) {
            $peminjaman->ruang->update(['status' => 'Dipinjam']);
        }

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function reject($kodePinjam)
    {
        $peminjaman = Peminjaman::where('kode_pinjam', $kodePinjam)->firstOrFail();

        $peminjaman->update(['status' => 'Canceled']);

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil ditolak.');
    }

    public function indexPengembalian()
    {
        $peminjaman = Peminjaman::with(['ruang', 'detailPeminjaman.barang'])
                        ->where('status', 'Pending')
                        ->where('catatan', 'Pengembalian')
                        ->get();

        return view('admin.peminjaman.pengembalian', compact('peminjaman'));
    }

    public function approvePengembalian($kodePinjam)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman.barang', 'ruang')
                        ->where('kode_pinjam', $kodePinjam)
                        ->where('status', 'Pending')
                        ->firstOrFail();

        $peminjaman->update(['status' => 'Selesai', 'tanggal_kembali' => now()]);

        foreach ($peminjaman->detailPeminjaman as $detail) {
            $detail->barang->update(['status' => 'Tersedia']);
        }

        if ($peminjaman->ruang) {
            $peminjaman->ruang->update(['status' => 'Tersedia']);
        }

        return redirect()->route('admin.peminjaman.pengembalian')->with('success', 'Pengembalian berhasil disetujui.');
    }

    public function laporan(Request $request)
    {
        $query = Peminjaman::with(['ruang', 'detailPeminjaman.barang', 'user']);

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
