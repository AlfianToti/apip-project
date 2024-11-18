<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\Peminjaman;
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
    public function dashboard()
    {
        // Hitung jumlah kelas, barang, dan riwayat peminjaman
        $jumlahKelas = Ruang::count();
        $jumlahBarang = Barang::count();
        $jumlahPeminjaman = Peminjaman::where('user_id', auth()->id())->count();

        // Kirim data ke view
        return view('pengguna.index', compact('jumlahKelas', 'jumlahBarang', 'jumlahPeminjaman'));
    }
}
