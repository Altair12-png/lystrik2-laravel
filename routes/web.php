<?php

use Illuminate\Support\Facades\Route;

// Import semua Controller yang akan digunakan
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Import Controller Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PelangganController as AdminPelangganController;
use App\Http\Controllers\Admin\TarifController as AdminTarifController;
use App\Http\Controllers\Admin\PenggunaanController as AdminPenggunaanController; // <== Pastikan ini diimpor dengan alias yang benar
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;

// Import Controller Pelanggan
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;
use App\Http\Controllers\Pelanggan\TagihanController as PelangganTagihanController;
use App\Http\Controllers\Pelanggan\PembayaranController as PelangganPembayaranController; // <== Jika Anda memiliki controller pembayaran untuk pelanggan


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sinilah Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dalam grup yang berisi middleware "web".
| Sekarang buat sesuatu yang hebat!
|
*/

// Rute Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rute untuk Login dan Logout
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Rute Registrasi User
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// =====================================================================================
// GRUP RUTE UNTUK ADMIN
// =====================================================================================
Route::middleware(['auth:web'])->prefix('admin')->name('admin.')->group(function () {
    // Rute Dashboard Admin
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Resource routes untuk kelola data pelanggan
    Route::resource('pelanggan', AdminPelangganController::class);

    // Resource routes untuk kelola data tarif
    Route::resource('tarif', AdminTarifController::class);

    // Resource routes untuk kelola data penggunaan (pemakaian listrik)
    // Resource routes untuk pembayaran
    Route::resource('pembayaran', AdminPembayaranController::class)->only(['index', 'show', 'update', 'destroy']);

    // Sekarang mencakup semua operasi CRUD: index, create, store, show, edit, update, destroy
    Route::resource('penggunaan', AdminPenggunaanController::class); // <== Hapus .only(...)

    // Anda bisa menambahkan rute admin lainnya di sini
    // ...
});


// =====================================================================================
// GRUP RUTE UNTUK PELANGGAN
// =====================================================================================
Route::middleware(['auth:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    // Rute Dashboard Pelanggan
    Route::get('dashboard', [PelangganDashboardController::class, 'index'])->name('dashboard');

    // Rute untuk melihat tagihan
    Route::get('tagihan', [PelangganTagihanController::class, 'index'])->name('tagihan.index');
    
    // Rute untuk melihat pembayaran (jika ada controller Pembayaran untuk pelanggan)
    Route::resource('pembayaran', PelangganPembayaranController::class)->only(['index', 'create', 'store', 'show']);

    // Anda bisa menambahkan rute pelanggan lainnya di sini
    // ...
});
