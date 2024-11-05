<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    public function index()
    {
        $title = 'MI | Data Peminjaman';
        $peminjamans = Peminjaman::with(['user', 'barang', 'ruang'])->get();
        return view('pengguna.peminjaman.index', compact('title', 'peminjamans'));
    }

    public function create()
    {
        $title = 'MI | Buat Peminjaman';
        $barang = \App\Models\Barang::all(); // Pastikan model Barang ada dan data tersedia
        $ruang = \App\Models\Ruang::all();   // Pastikan model Ruang ada dan data tersedia

        return view('pengguna.peminjaman.keranjang', compact('title', 'barang', 'ruang'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'barang_ids' => 'required|array',
            'barang_ids.*' => 'integer',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'catatan' => 'nullable|string',
        ]);

        // Simpan data peminjaman
        foreach ($request->barang_ids as $barang_id) {
            Peminjaman::create([
                'user_id' => $request->user_id,
                'barang_id' => $barang_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'catatan' => $request->catatan,
            ]);
        }

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dibuat.');
    }
}
