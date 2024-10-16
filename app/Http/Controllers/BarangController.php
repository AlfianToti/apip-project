<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // Menampilkan daftar barang
    public function index()
    {
        $barangs = Barang::all();
        return view('barang.index', compact('barangs'));
    }

    // Menampilkan form untuk menambah barang baru
    public function create()
    {
        return view('barang.create');
    }

    // Menyimpan barang baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        Barang::create([
            'nama' => $request->nama,
            'status' => $request->status,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    // Menampilkan form edit barang berdasarkan kode_barang
    public function edit($kode_barang)
    {
        $barang = Barang::findOrFail($kode_barang);
        return view('barang.edit', compact('barang'));
    }

    // Memperbarui barang yang dipilih
    public function update(Request $request, $kode_barang)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $barang = Barang::findOrFail($kode_barang);
        $barang->update([
            'nama' => $request->nama,
            'status' => $request->status,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    // Menghapus barang berdasarkan kode_barang
    public function destroy($kode_barang)
    {
        $barang = Barang::findOrFail($kode_barang);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
