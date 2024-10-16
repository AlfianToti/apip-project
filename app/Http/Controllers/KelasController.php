<?php

namespace App\Http\Controllers;
use App\Models\Ruang;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        
        $ruangs = Ruang::all();

      
        return view('pengguna.kelas.index', compact('ruangs'));
    }
}
