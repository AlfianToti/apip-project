<?php
use App\Http\Controllers\AdminPeminjamanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Halaman Landing untuk pengguna yang belum login
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        if (Auth::check()) {
            return Auth::user()->role === 'admin' 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('masterpengguna');
        }
        return view('welcome');
    })->name('landing');

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/login', [AuthController::class, 'login']);    

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route untuk logout
Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route khusus admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/masteradmin', function () {
        return view('masteradmin');
    });

    // Route CRUD untuk Ruang
    Route::resource('/ruang', RuangController::class)->except(['show']);

    // Route CRUD untuk Barang
    Route::resource('/barang', BarangController::class)->except(['show']);

    // Route untuk manajemen pengguna
    Route::get('/adminusers', [AuthController::class, 'showUsers'])->name('admin.users');
    Route::delete('/admin/users/{id}', [AuthController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admindashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Route untuk approval peminjaman dan pengembalian
    Route::get('/peminjaman-admin', [AdminPeminjamanController::class, 'index'])->name('admin.peminjaman.index');
    Route::get('/pengembalian-admin', [AdminPeminjamanController::class, 'indexPengembalian'])->name('admin.peminjaman.pengembalian');
    Route::patch('/peminjaman-admin/{kode_pinjam}/approve', [AdminPeminjamanController::class, 'approve'])->name('admin.peminjaman.approve');
    Route::patch('/peminjaman-admin/{kode_pinjam}/reject', [AdminPeminjamanController::class, 'reject'])->name('admin.peminjaman.reject');
    Route::patch('/peminjaman-admin/{kode_pinjam}/approve-pengembalian', [AdminPeminjamanController::class, 'approvePengembalian'])->name('admin.peminjaman.approvePengembalian');

    // Route untuk laporan peminjaman
    Route::get('/laporan-peminjaman', [AdminPeminjamanController::class, 'laporan'])->name('admin.peminjaman.laporan');
});

// Route khusus pengguna
Route::middleware(['auth', 'role:pengguna'])->group(function () {
    Route::get('/masterpengguna', [DashboardController::class, 'dashboard'])->name('masterpengguna');

    // Route untuk melihat ruang dan barang
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::get('/alat', [AlatController::class, 'index'])->name('alat.index');

    // Route untuk Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'indexRiwayat'])->name('peminjaman.index');
    Route::get('/peminjaman/{kode_pinjam}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::get('/buat-peminjaman', [PeminjamanController::class, 'indexPeminjaman'])->name('peminjaman.ruangan.index');
    Route::post('/buat-peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.ruangan.store');
    Route::patch('/peminjaman/{kode_pinjam}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');

    // Route untuk Keranjang
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::get('/keranjang/create', [KeranjangController::class, 'create'])->name('keranjang.create');
    Route::post('/keranjang/store', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::delete('/keranjang/{kode_detail}', [KeranjangController::class, 'remove'])->name('keranjang.remove');
    Route::post('/keranjang/submit', [KeranjangController::class, 'submit'])->name('keranjang.submit');
});
