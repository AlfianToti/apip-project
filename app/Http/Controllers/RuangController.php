<?php

namespace App\Http\Controllers;
use App\Models\Ruang;
use Illuminate\Http\Request;

class RuangController extends Controller
{
   // Fungsi untuk menampilkan daftar ruang
   public function index()
   {
       $ruangs = Ruang::all(); // Mengambil semua data ruang
       return view('ruang.index', compact('ruangs')); // Mengirim data ke view index
   }

   // Fungsi untuk menampilkan halaman create
   public function create()
   {
       return view('ruang.create'); // Mengembalikan view create
   }

   // Fungsi untuk menyimpan data ruang
   public function store(Request $request)
   {
       $request->validate([
           'nama_ruang' => 'required|string|max:255',
           'status' => 'required|boolean',
       ]);

       Ruang::create($request->all()); // Menyimpan data baru
       return redirect()->route('ruang.index')->with('success', 'Ruang berhasil ditambahkan.'); // Kembali ke index dengan pesan sukses
   }

   // Fungsi untuk menampilkan halaman edit
   public function edit($kode_ruang)
   {
       $ruang = Ruang::findOrFail($kode_ruang); // Mencari ruang berdasarkan ID
       return view('ruang.edit', compact('ruang')); // Mengembalikan view edit dengan data ruang
   }

   // Fungsi untuk memperbarui data ruang
   public function update(Request $request, $kode_ruang)
   {
       $request->validate([
           'nama_ruang' => 'required|string|max:255',
           'status' => 'required|boolean',
       ]);

       $ruang = Ruang::findOrFail($kode_ruang); // Mencari ruang berdasarkan ID
       $ruang->update($request->all()); // Memperbarui data ruang
       return redirect()->route('ruang.index')->with('success', 'Ruang berhasil diperbarui.'); // Kembali ke index dengan pesan sukses
   }

   // Fungsi untuk menghapus data ruang
   public function destroy($kode_ruang)
   {
       $ruang = Ruang::findOrFail($kode_ruang); // Mencari ruang berdasarkan ID
       $ruang->delete(); // Menghapus ruang
       return redirect()->route('ruang.index')->with('success', 'Ruang berhasil dihapus.'); // Kembali ke index dengan pesan sukses
   }
}
