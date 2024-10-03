<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        $title = 'MI | Data Alat';
        return view('pengguna.alat.index', compact('title'));
    }
}

