<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        $barang = Barang::all();

       
        return view('pengguna.alat.index', compact('barang'));
    }
}

