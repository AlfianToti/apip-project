<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\Ruang;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $totalBarang = Barang::count();
    $totalRuang = Ruang::count();
  
    $totalUsers = User::where('role', '!=', 'admin')->count();

    return view('admin.dashboard_admin', compact('totalBarang', 'totalRuang', 'totalUsers'));
    
}
}
