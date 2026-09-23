<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// Rute Halaman Utama
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rute Login & Logout
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ----------------------------------------------------
// RUTE SETUP (HANYA DIAKSES SEKALI LALU HAPUS)
// ----------------------------------------------------
Route::get('/setup-admin', function () {
    $user = User::firstOrCreate(
        ['email' => 'admin@vxai.online'],
        [
            'name' => 'Izak Robinson Koroh',
            'password' => Hash::make('rahasia123'),
            'role_id' => 1
        ]
    );
    return 'Berhasil! Akun Super Admin telah dibuat. Email: admin@vxai.online | Password: rahasia123';
});
// ----------------------------------------------------

// Rute Super Admin (Hanya bisa diakses jika sudah login)
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Rute Manajemen User
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    // Rute Import CSV
    Route::post('/users/import', [AdminController::class, 'importUsers'])->name('admin.users.import');
    // Rute Melihat Hasil Koding Siswa
    Route::get('/submissions', [AdminController::class, 'submissions'])->name('admin.submissions');
    
    // Rute Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update'); // RUTE BARU
});

// Rute Sementara untuk Guru dan Siswa
Route::get('/guru', function () { return 'Ini Halaman Dashboard Guru. (Sedang dibangun)'; })->middleware('auth');
// Rute Siswa (Harus login)
Route::middleware('auth')->prefix('siswa')->group(function () {
    Route::get('/', [StudentController::class, 'dashboard'])->name('siswa.dashboard');
    Route::get('/playground', [StudentController::class, 'playground'])->name('siswa.playground'); // RUTE BARU
    // Rute Submit Kode dari Playground
    Route::post('/playground/submit', [StudentController::class, 'submitCode'])->name('siswa.playground.submit');
});