<?php

use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\Admin\NilaiController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/berita', [PublicController::class, 'allNews'])->name('news.index');
Route::get('/berita/{news}', [PublicController::class, 'showNews'])->name('news.show');

// Dashboard Route (role-based redirect)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'permission:kelola_news'])->group(function () {
    Route::resource('admin/news', NewsController::class, [
        'as' => 'admin',
        'names' => [
            'index' => 'admin.news.index',
            'create' => 'admin.news.create',
            'store' => 'admin.news.store',
            'edit' => 'admin.news.edit',
            'update' => 'admin.news.update',
            'destroy' => 'admin.news.destroy',
        ]
    ]);
});

// Kelola Mahasiswa (Admin only)
Route::middleware(['auth', 'permission:kelola_mahasiswa'])->group(function () {
    Route::get('/admin/mahasiswa', [MahasiswaController::class, 'index'])->name('admin.mahasiswa.index');
});

// Kelola Mata Kuliah (Admin only)
Route::middleware(['auth', 'permission:kelola_mata_kuliah'])->group(function () {
    Route::get('/admin/mata-kuliah', [MataKuliahController::class, 'index'])->name('admin.mata-kuliah.index');
});

// Kelola Nilai (Admin & Dosen)
Route::middleware(['auth', 'permission:kelola_nilai'])->group(function () {
    Route::get('/admin/nilai', [NilaiController::class, 'index'])->name('admin.nilai.index');
});

// Kelola Users (Admin only)
Route::middleware(['auth', 'permission:kelola_users'])->group(function () {
    Route::get('/admin/users', [UsersController::class, 'index'])->name('admin.users.index');
});

require __DIR__.'/auth.php';
