<?php

use App\Http\Controllers\Admin\AspirasiController;
use App\Http\Controllers\Admin\DashboardController as DashboardAdmin;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Siswa\DashboardController as DashboardSiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
   // cek apakh dia login apa tidak
   if(Auth::check()){
    if(Auth::user()->role == 'admin'){
        return redirect()->route('admin.dashboard');
    } else{
        return redirect()->route('siswa.dashboard');
    }
   }
   // kalau tidak login
   return redirect('/login');
});

// // proses untuk proses login
Route::get('/login', [AuthController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->middleware('guest')->name('login.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// //routing untuk admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/dashboard', [DashboardAdmin::class, 'index'])->name('dashboard');

    // kelola data siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');
    Route::get('/form-siswa', [SiswaController::class, 'create'])->name('form-siswa');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('tambah-siswa');
    Route::get('/siswa/delete/{siswa}', [SiswaController::class, 'delete'])->name('hapus-siswa'); // route model binding
    Route::get('/siswa/edit/{siswa}', [SiswaController::class, 'edit'])->name('form-edit-siswa'); // route model binding
    Route::put('/siswa', [SiswaController::class, 'update'])->name('edit-siswa'); // route model binding

    // kelola data kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::get('/form-kategori', [KategoriController::class, 'create'])->name('form-kategori');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('tambah-kategori');
    Route::get('/kategori/edit/{kategori}', [KategoriController::class, 'edit'])->name('form-edit-kategori');
    Route::put('/kategori', [KategoriController::class, 'update'])->name('edit-kategori');
    Route::get('/kategori/delete/{kategori}', [KategoriController::class, 'delete'])->name ('hapus-kategori');

    // kelola data aspirasi
    Route::get('/aspirasi',[AspirasiController::class, 'index'])->name ('aspirasi');
    Route::post('/get-aspirasi', [AspirasiController::class, 'getTanggapanByAspirasi'])->name ('get-aspirasi');
    Route::post('/tanggapan', [AspirasiController::class, 'addTanggapan'])->name ('tanggapan');
    Route::get('/aspirasi/delete/{aspirasi}', [AspirasiController::class, 'delete'])->name ('hapus-aspirasi');

    // Laporan Aspirasi
    Route::get('/laporan', [LaporanController::class, 'index'])->name ('laporan');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name ('cetak-laporan');

});
//routing untuk siswa
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function(){
    Route::get('/dashboard', [DashboardSiswa::class, 'index'])->name('dashboard');
    Route::get('/aspirasi', [DashboardSiswa::class, 'tambahAspirasi'])->name('tambah-aspirasi');
    Route::post('/aspirasi', [DashboardSiswa::class, 'simpanAspirasi'])->name('proses-tambah');
    Route::get('/aspirasi/edit/{aspirasi}', [DashboardSiswa::class, 'editAspirasi'])->name('edit-aspirasi');
    Route::put('/aspirasi', [DashboardSiswa::class, 'updateAspirasi'])->name('proses-edit');
    Route::get('/aspirasi/delete/{aspirasi}', [DashboardSiswa::class, 'hapusAspirasi'])->name('hapus-aspirasi');

});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');
