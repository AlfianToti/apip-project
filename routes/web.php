<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KeranjangController;
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
    // Route untuk menampilkan riwayat peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'indexRiwayat'])->name('peminjaman.index');
    
    // Route untuk menampilkan detail peminjaman tertentu (opsional)
    Route::get('/peminjaman/{kode_pinjam}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    
    // Route untuk menampilkan form pembuatan janji peminjaman
    Route::get('/buat-peminjaman', [PeminjamanController::class, 'indexPeminjaman'])->name('peminjaman.ruangan.index');
    
    // Route untuk menyimpan janji peminjaman yang baru
    Route::post('/buat-peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.ruangan.store');

    // Route untuk menampilkan keranjang peminjaman barang
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    
    // Route untuk menampilkan form penambahan barang ke keranjang
    Route::get('/keranjang/create', [KeranjangController::class, 'create'])->name('keranjang.create');
    
    // Route untuk menambah barang ke keranjang
    Route::post('/keranjang/store', [KeranjangController::class, 'store'])->name('keranjang.store');
    
    // Route untuk menghapus barang dari keranjang
    Route::delete('/keranjang/{kode_detail}', [KeranjangController::class, 'remove'])->name('keranjang.remove');
    
    // Route untuk menyelesaikan peminjaman barang di keranjang
    Route::post('/keranjang/submit', [KeranjangController::class, 'submit'])->name('keranjang.submit');

    Route::patch('/peminjaman/{kode_pinjam}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
});
