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
    // Fungsi untuk menampilkan daftar peminjaman pengguna
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'barang', 'ruang'])
            ->where('user_id', Auth::id())
            ->get();
        return view('pengguna.peminjaman.index', compact('peminjamans'));
    }

    // Fungsi untuk menampilkan form keranjang peminjaman
    public function createKeranjang()
    {
        $existingPeminjaman = Peminjaman::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingPeminjaman) {
            return redirect()->route('peminjaman.index')->with('error', 'Anda sudah memiliki peminjaman yang belum dikembalikan.');
        }

        $barangs = Barang::all();
        $ruangs = Ruang::all();

        // Mengambil data keranjang berdasarkan user yang sedang login
        $keranjangItems = Keranjang::where('user_id', auth()->id())->with('barang')->get();

        return view('pengguna.peminjaman.keranjang', compact('barangs', 'ruangs', 'keranjangItems'));
    }

    // Fungsi untuk menghapus barang dari keranjang
    public function removeFromKeranjang($id)
    {
        $keranjangItem = Keranjang::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $keranjangItem->delete();

        return redirect()->route('peminjaman.keranjang')->with('success', 'Barang berhasil dihapus dari keranjang.');
    }

    // Fungsi untuk menambahkan barang ke dalam keranjang peminjaman
    public function addToKeranjang(Request $request)
{
    $request->validate([
        'kode_barang' => 'required|exists:barang,kode_barang',
        'kode_ruang' => 'required|exists:ruang,kode_ruang',
    ]);

    // Pastikan keranjang hanya memiliki satu ruangan
    $existingRuang = Keranjang::where('user_id', auth()->id())->where('kode_ruang', '!=', $request->kode_ruang)->first();
    if ($existingRuang) {
        return redirect()->route('peminjaman.keranjang')->with('error', 'Anda hanya dapat memilih satu ruangan per keranjang.');
    }

    // Simpan item keranjang
    Keranjang::create([
        'user_id' => auth()->id(),
        'kode_barang' => $request->kode_barang,
        'kode_ruang' => $request->kode_ruang,
    ]);

    return redirect()->route('peminjaman.keranjang')->with('success', 'Barang berhasil ditambahkan ke keranjang.');
}


    // Fungsi untuk menyimpan peminjaman dari keranjang
    public function storeKeranjang(Request $request)
    {
        $request->validate([
            'kode_ruang' => 'required|exists:ruang,kode_ruang',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'catatan' => 'nullable|string',
        ]);

        // Ambil barang dari keranjang sesi
        $barangIds = session()->get('keranjang', []);

        if (empty($barangIds)) {
            return redirect()->route('peminjaman.keranjang')->with('error', 'Keranjang peminjaman kosong.');
        }

        foreach ($barangIds as $barangId) {
            Peminjaman::create([
                'user_id' => Auth::id(),
                'kode_barang' => $barangId,
                'kode_ruang' => $request->kode_ruang,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'catatan' => $request->catatan,
                'status' => 'pending',
            ]);
        }

        // Hapus keranjang setelah peminjaman berhasil disimpan
        session()->forget('keranjang');

        return redirect()->route('peminjaman.index')->with('success', 'Permintaan peminjaman berhasil diajukan.');
    }

    // Fungsi untuk menampilkan data permintaan peminjaman kepada admin
    public function adminIndex()
    {
        // Mengambil data peminjaman dengan status 'pending'
        $peminjamanRequests = Peminjaman::with(['user', 'barang', 'ruang'])
            ->where('status', 'pending')
            ->get();
        
        return view('admin.request-peminjaman', compact('peminjamanRequests'));
    }

    // Fungsi untuk menampilkan daftar permintaan pengembalian kepada admin
    public function adminReturnIndex()
    {
        $pengembalianRequests = Peminjaman::with(['user', 'barang', 'ruang'])
            ->where('status', 'return_pending')
            ->get();

        return view('admin.request-pengembalian', compact('pengembalianRequests'));
    }

    // Fungsi untuk admin menyetujui peminjaman
    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'approved';
        $peminjaman->save();

        return redirect()->route('admin.request.peminjaman')->with('success', 'Peminjaman berhasil disetujui.');
    }

    // Fungsi untuk admin menolak peminjaman
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'rejected';
        $peminjaman->save();

        return redirect()->route('admin.request.peminjaman')->with('success', 'Peminjaman berhasil ditolak.');
    }

    // Fungsi untuk pengguna mengajukan pengembalian
    public function requestReturn($id)
    {
        $peminjaman = Peminjaman::where('user_id', Auth::id())->findOrFail($id);

        if ($peminjaman->status === 'approved') {
            $peminjaman->status = 'return_pending';
            $peminjaman->save();

            return redirect()->route('peminjaman.index')->with('success', 'Pengajuan pengembalian berhasil.');
        }

        return redirect()->route('peminjaman.index')->with('error', 'Pengembalian hanya bisa diajukan untuk peminjaman yang disetujui.');
    }

    // Fungsi untuk admin menyetujui pengembalian
    public function approveReturn($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        if ($peminjaman->status === 'return_pending') {
            $peminjaman->status = 'returned';
            $peminjaman->save();

            return redirect()->route('admin.request.pengembalian')->with('success', 'Pengembalian berhasil disetujui.');
        }

        return redirect()->route('admin.request.pengembalian')->with('error', 'Status pengembalian tidak valid.');
    }

    // Fungsi untuk admin menolak pengembalian
    public function rejectReturn($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        if ($peminjaman->status === 'return_pending') {
            $peminjaman->status = 'approved';
            $peminjaman->save();

            return redirect()->route('admin.request.pengembalian')->with('success', 'Pengembalian berhasil ditolak.');
        }

        return redirect()->route('admin.request.pengembalian')->with('error', 'Status pengembalian tidak valid.');
    }

    // Fungsi untuk menampilkan laporan
    public function laporan()
    {
        $peminjamanRecords = Peminjaman::with(['user', 'barang', 'ruang'])->get();
        
        return view('admin.laporan-peminjaman', compact('peminjamanRecords'));
    }
}
