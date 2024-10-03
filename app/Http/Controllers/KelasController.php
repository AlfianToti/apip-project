<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $title = 'MI | Data Kelas';
        return view('pengguna.kelas.index', compact('title'));
    }
}
