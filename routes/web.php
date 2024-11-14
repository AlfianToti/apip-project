<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DashboardController;

use Illuminate\Support\Facades\Route;

// Halaman Landing yang hanya bisa diakses oleh pengguna yang belum login
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        if (Auth::check()) {
            // Redirect berdasarkan peran pengguna
            return Auth::user()->role === 'admin' 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('masterpengguna');
        }
        return view('welcome'); // Hanya untuk pengguna yang belum login
    })->name('landing');
    

    // Route untuk login
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/login', [AuthController::class, 'login']);    

    // Route untuk register    
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route untuk logout yang hanya bisa diakses oleh pengguna yang sudah login
Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route khusus untuk admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/masteradmin', function (){
        return view('masteradmin');
    });
    // Route crud ruang
    Route::get('/ruang', [RuangController::class, 'index'])->name('ruang.index');
    Route::get('/ruang/create', [RuangController::class, 'create'])->name('ruang.create');
    Route::post('/ruang', [RuangController::class, 'store'])->name('ruang.store');
    Route::get('/ruang/{kode_ruang}/edit', [RuangController::class, 'edit'])->name('ruang.edit');
    Route::put('/ruang/{kode_ruang}', [RuangController::class, 'update'])->name('ruang.update');
    Route::delete('/ruang/{kode_ruang}', [RuangController::class, 'destroy'])->name('ruang.destroy');

    // Route crud barang
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/{kode_barang}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{kode_barang}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{kode_barang}', [BarangController::class, 'destroy'])->name('barang.destroy');

    // Route crud user
    Route::get('/adminusers', [AuthController::class, 'showUsers'])->name('admin.users');
    Route::delete('/admin/users/{id}', [AuthController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admindashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Route untuk approval peminjaman dan pengembalian
    Route::get('/admin/request-peminjaman', [PeminjamanController::class, 'adminIndex'])->name('admin.request.peminjaman');
    Route::post('/admin/request-peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('admin.request.peminjaman.approve');
    Route::post('/admin/request-peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('admin.request.peminjaman.reject');

    Route::get('/admin/request-pengembalian', [PeminjamanController::class, 'adminReturnIndex'])->name('admin.request.pengembalian');
    Route::post('/admin/request-pengembalian/{id}/approve', [PeminjamanController::class, 'approveReturn'])->name('admin.request.pengembalian.approve');
    Route::post('/admin/request-pengembalian/{id}/reject', [PeminjamanController::class, 'rejectReturn'])->name('admin.request.pengembalian.reject');

    // Route untuk laporan
    Route::get('/admin/laporan-peminjaman', [PeminjamanController::class, 'laporan'])->name('admin.laporan.peminjaman');
});

// Route khusus untuk pengguna
Route::middleware(['auth', 'role:pengguna'])->group(function () {
    Route::get('/masterpengguna', function () {
        return view('pengguna.index');
    })->name('masterpengguna');
    // Route untuk lihat ruang
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    // Route untuk lihat barang
    Route::get('/alat', [AlatController::class, 'index'])->name('alat.index');
    // Route untuk crud peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/keranjang', [PeminjamanController::class, 'createKeranjang'])->name('peminjaman.keranjang');
    Route::post('/keranjang/add', [PeminjamanController::class, 'addToKeranjang'])->name('peminjaman.keranjang.add');
    Route::post('/keranjang/store', [PeminjamanController::class, 'storeKeranjang'])->name('peminjaman.keranjang.store');
    Route::post('/peminjaman/{id}/return', [PeminjamanController::class, 'requestReturn'])->name('peminjaman.return');
    Route::post('/keranjang/remove/{id}', [PeminjamanController::class, 'removeFromKeranjang'])->name('peminjaman.keranjang.remove');
});
