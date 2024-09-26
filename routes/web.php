<?php

use App\Http\Controllers\RuangController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function (){
   return view('auth/login'); 
});

Route::get('/register', function (){
    return view('auth/register'); 
 });
 
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