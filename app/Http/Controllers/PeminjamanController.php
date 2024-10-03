<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $title = 'MI | Data Pinjam';
        return view('pengguna.peminjaman.index', compact('title'));
    }
}
