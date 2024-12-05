<?php

namespace App\Http\Controllers;

use App\Models\DetailPeminjamanRuang;
use App\Models\Peminjaman;
use App\Models\Ruang;
use Illuminate\Http\Request;

class DetailRuangController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::where('user_id', auth()->id())
                                ->where('status', 'Pending')
                                ->first();

        if (!$peminjaman) {
            return redirect()->route('peminjaman.ruangan.index')->withErrors('Silakan buat peminjaman terlebih dahulu.');
        }

        // Mengambil tanggal pinjam dan tanggal kembali dari session
        $tanggalPinjam = session('tanggal_pinjam');
        $tanggalKembali = session('tanggal_kembali');

        $ruangDipinjam = $peminjaman->detailPeminjamanRuang->load('ruang');

        $ruangTersedia = Ruang::whereNotIn('kode_ruang', $ruangDipinjam->pluck('ruang.kode_ruang'))
                        ->whereDoesntHave('detailPeminjamanRuang', function ($query) use ($tanggalPinjam, $tanggalKembali) {
                            // Saring ruang yang memiliki peminjaman dalam rentang waktu yang diminta
                            $query->where(function ($subQuery) use ($tanggalPinjam, $tanggalKembali) {
                                $subQuery->whereBetween('tanggal_pinjam_ruang', [$tanggalPinjam, $tanggalKembali])
                                    ->orWhere(function ($subSubQuery) use ($tanggalPinjam, $tanggalKembali) {
                                        $subSubQuery->where('tanggal_kembali_ruang', '>=', $tanggalPinjam)
                                            ->where('tanggal_kembali_ruang', '<=', $tanggalKembali);
                                    });
                            });
                        })
                        ->orderBy('nama_ruang', 'asc')
                        ->select('kode_ruang', 'nama_ruang')
                        ->paginate(5);

// You can access $ruangTersedia like a paginated result:
$ruangTersedia->appends(request()->all()); // To preserve query parameters for pagination links



        return view('pengguna.peminjaman.keranjangr', compact( 'ruangDipinjam', 'peminjaman', 'ruangTersedia'));
    }
    
    public function store(Request $request)
    {
        // Ambil peminjaman yang sedang berlangsung
        $peminjaman = Peminjaman::where('user_id', auth()->id())
                                ->where('status', 'Pending')
                                ->first();

        if (!$peminjaman) {
            return redirect()->route('peminjaman.ruangan.index')->withErrors('Silakan mengisi form peminjaman terlebih dahulu.');
        }

        // Validasi inputan
        $request->validate([
            'kode_ruang' => 'required|exists:ruang,kode_ruang',
        ]);   

        // Mengambil tanggal pinjam dan tanggal kembali dari session
        $tanggalPinjam = session('tanggal_pinjam');
        $tanggalKembali = session('tanggal_kembali');

        // Periksa apakah barang/ruang yang dipilih tersedia dalam rentang waktu
        if ($request->kode_ruang) {
            $ruang = Ruang::where('kode_ruang', $request->kode_ruang)->first();
            $ruangDipinjam = $ruang->detailPeminjamanRuang->whereBetween('tanggal_pinjam_ruang', [$tanggalPinjam, $tanggalKembali])->count();
            if ($ruangDipinjam > 0) {
                return redirect()->route('detail.index')->withErrors('Ruangan sudah dipinjam dalam rentang waktu ini.');
            }
        } else {
            return redirect()->route('detail.index')->withErrors('Silakan pilih ruang untuk dipinjam.');
        }

        // Generate kode detail peminjaman
        $detailCount = DetailPeminjamanRuang::where('kode_pinjam', $peminjaman->kode_pinjam)->count();
        $detailNumber = str_pad($detailCount + 1, 3, '0', STR_PAD_LEFT);
        $kodeDetail = "DT-R-{$peminjaman->kode_pinjam}-{$detailNumber}";

        // Menyimpan detail peminjaman (baik barang atau ruang, atau keduanya)
        DetailPeminjamanRuang::create([
            'kode_detail_ruang' => $kodeDetail,
            'kode_pinjam' => $peminjaman->kode_pinjam,
            'kode_ruang' => $request->kode_ruang,
            'tanggal_req_pinjam' => $tanggalPinjam,
            'tanggal_req_kembali' => $tanggalKembali,
        ]);

        return redirect()->route('detail.index')->with('success', 'Peminjaman ruang berhasil ditambahkan ke keranjang.');
    }
        // Menampilkan detail peminjaman ruang berdasarkan kode peminjaman
    public function remove($kode_detail_ruang)
    {
        $detail = DetailPeminjamanRuang::where('kode_detail_ruang', $kode_detail_ruang)->first();

        if ($detail) {
            $detail->delete();
        }

        return redirect()->route('detail.index')->with('success', 'Peminjaman ruang berhasil dihapus dari keranjang.');
    }
    
    public function submit()
    {
        return redirect()->route('keranjang.index')->with('success', 'Peminjaman ruang berhasil diajukan, lanjut memilih barang.');
    }
}
