<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\PeminjamanController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

// Route untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register.form');

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/masteradmin', function (){
    return view('masteradmin');
});

//Route Ruang
Route::get('/ruang', [RuangController::class, 'index'])->name('ruang.index');
Route::get('/ruang/create', [RuangController::class, 'create'])->name('ruang.create');
Route::post('/ruang', [RuangController::class, 'store'])->name('ruang.store');
Route::get('/ruang/{kode_ruang}/edit', [RuangController::class, 'edit'])->name('ruang.edit');
Route::put('/ruang/{kode_ruang}', [RuangController::class, 'update'])->name('ruang.update');
Route::delete('/ruang/{kode_ruang}', [RuangController::class, 'destroy'])->name('ruang.destroy');


Route::get('/masterpengguna', function () {
    return view('pengguna.index');
})->name('masterpengguna');

Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
Route::get('/alat', [AlatController::class, 'index'])->name('alat.index');
Route::get('/peminjaman', [PeminjamanController::class,'index'])->name('peminjaman.index');

