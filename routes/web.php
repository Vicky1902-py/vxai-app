<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. RUTE AKSES PUBLIK & GOOGLE ADSENSE
|--------------------------------------------------------------------------
| Semua rute ini dapat diakses secara publik oleh siapa saja tanpa login,
| mendukung crawler Google untuk persetujuan Google AdSense & SEO organik.
*/

// Beranda Utama
Route::get('/', [PublicController::class, 'index'])->name('home');

// Live Coding Playground Publik
Route::get('/playground', [PublicController::class, 'playground'])->name('public.playground');
Route::post('/playground/submit', [PublicController::class, 'submitCode'])->name('public.playground.submit');

// Panduan & Tutorial Koding Interaktif
Route::get('/panduan', [PublicController::class, 'tutorials'])->name('public.tutorials');

// Portal Berita & Tips Koding, AI, Komputer, Android
Route::get('/berita', [PublicController::class, 'newsIndex'])->name('public.news');
Route::get('/berita/{slug}', [PublicController::class, 'newsDetail'])->name('public.news.detail');

// Halaman Legalitas Wajib Google AdSense
Route::get('/privacy-policy', [PublicController::class, 'privacyPolicy'])->name('privacy');
Route::get('/terms', [PublicController::class, 'terms'])->name('terms');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');

// Endpoint Resmi ads.txt (Dinamis dari Pengaturan Admin)
Route::get('/ads.txt', [PublicController::class, 'adsTxt'])->name('ads.txt');

// Jalankan Migrasi Database Otomatis jika diperlukan
Route::get('/migrate-db', [AdminController::class, 'runMigration'])->name('migrate.db');

/*
|--------------------------------------------------------------------------
| 2. AUTENTIKASI (LOGIN & LOGOUT)
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 3. RUTE SUPER ADMIN (DIKUNCI KETAT: ROLE 1)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Manajemen User Lengkap (CRUD)
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::post('/users/import', [AdminController::class, 'importUsers'])->name('admin.users.import');

    // Monitoring Hasil Koding Siswa & Tamu
    Route::get('/submissions', [AdminController::class, 'submissions'])->name('admin.submissions');
    Route::post('/submissions/{id}/grade', [AdminController::class, 'gradeSubmission'])->name('admin.submissions.grade');

    // Manajemen Berita & Artikel Teknologi (CRUD)
    Route::get('/articles', [AdminController::class, 'articles'])->name('admin.articles');
    Route::get('/articles/create', [AdminController::class, 'createArticle'])->name('admin.articles.create');
    Route::post('/articles', [AdminController::class, 'storeArticle'])->name('admin.articles.store');
    Route::get('/articles/{id}/edit', [AdminController::class, 'editArticle'])->name('admin.articles.edit');
    Route::put('/articles/{id}', [AdminController::class, 'updateArticle'])->name('admin.articles.update');
    Route::delete('/articles/{id}', [AdminController::class, 'deleteArticle'])->name('admin.articles.delete');

    // Manajemen Modul Playground & Tantangan Koding (CRUD)
    Route::get('/playground', [AdminController::class, 'playgroundChallenges'])->name('admin.playground');
    Route::get('/playground/create', [AdminController::class, 'createPlaygroundChallenge'])->name('admin.playground.create');
    Route::post('/playground', [AdminController::class, 'storePlaygroundChallenge'])->name('admin.playground.store');
    Route::get('/playground/{id}/edit', [AdminController::class, 'editPlaygroundChallenge'])->name('admin.playground.edit');
    Route::put('/playground/{id}', [AdminController::class, 'updatePlaygroundChallenge'])->name('admin.playground.update');
    Route::delete('/playground/{id}', [AdminController::class, 'deletePlaygroundChallenge'])->name('admin.playground.delete');
    Route::post('/playground/{id}/toggle', [AdminController::class, 'togglePlaygroundChallenge'])->name('admin.playground.toggle');
    Route::post('/playground/reset-defaults', [AdminController::class, 'resetDefaultPlaygroundChallenges'])->name('admin.playground.reset');
    
    // Global Settings & Google AdSense Configuration
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
});

/*
|--------------------------------------------------------------------------
| 4. RUTE GURU (DIKUNCI KETAT: ROLE 2)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:guru'])->prefix('guru')->group(function () {
    Route::get('/', [TeacherController::class, 'dashboard'])->name('guru.dashboard');
    Route::post('/submissions/{id}/grade', [TeacherController::class, 'grade'])->name('guru.submissions.grade');
});

/*
|--------------------------------------------------------------------------
| 5. RUTE SISWA (DIKUNCI: ROLE 3)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {
    Route::get('/', [StudentController::class, 'dashboard'])->name('siswa.dashboard');
    Route::get('/playground', function () {
        return redirect()->route('public.playground');
    })->name('siswa.playground');
    Route::post('/playground/submit', [PublicController::class, 'submitCode'])->name('siswa.playground.submit');
});