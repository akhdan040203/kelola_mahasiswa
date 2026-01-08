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
    Route::resource('admin/mata-kuliah', MataKuliahController::class)->names([
        'index' => 'admin.mata-kuliah.index',
        'create' => 'admin.mata-kuliah.create',
        'store' => 'admin.mata-kuliah.store',
        'edit' => 'admin.mata-kuliah.edit',
        'update' => 'admin.mata-kuliah.update',
        'destroy' => 'admin.mata-kuliah.destroy',
    ]);
});

// Kelola KRS (Admin only)
Route::middleware(['auth', 'permission:kelola_krs'])->group(function () {
    Route::get('admin/krs', [App\Http\Controllers\Admin\KrsController::class, 'index'])->name('admin.krs.index');
    Route::get('admin/krs/{krs}', [App\Http\Controllers\Admin\KrsController::class, 'show'])->name('admin.krs.show');
    Route::post('admin/krs/{krs}/approve', [App\Http\Controllers\Admin\KrsController::class, 'approve'])->name('admin.krs.approve');
    Route::post('admin/krs/{krs}/reject', [App\Http\Controllers\Admin\KrsController::class, 'reject'])->name('admin.krs.reject');
    Route::post('admin/krs/{krs}/assign-dosen', [App\Http\Controllers\Admin\KrsController::class, 'storeDosenAssignment'])->name('admin.krs.assign-dosen');
});

// Kelola Nilai (Admin & Dosen)
Route::middleware(['auth', 'permission:kelola_nilai'])->group(function () {
    Route::get('/admin/nilai', [NilaiController::class, 'index'])->name('admin.nilai.index');
});

// Kelola Users (Admin only)
Route::middleware(['auth', 'permission:kelola_users'])->group(function () {
    Route::get('/admin/users', [UsersController::class, 'index'])->name('admin.users.index');
});

// Student Features
Route::middleware(['auth'])->group(function () {
    Route::resource('student/krs', App\Http\Controllers\Student\KrsController::class)->names([
        'index' => 'student.krs.index',
        'create' => 'student.krs.create',
        'store' => 'student.krs.store',
        'show' => 'student.krs.show',
        'edit' => 'student.krs.edit',
        'update' => 'student.krs.update',
        'destroy' => 'student.krs.destroy',
    ]);
    Route::post('student/krs/{krs}/submit', [App\Http\Controllers\Student\KrsController::class, 'submit'])->name('student.krs.submit');
});

// Dosen Features
Route::middleware(['auth'])->group(function () {
    Route::get('dosen/mata-kuliah', [App\Http\Controllers\Dosen\MataKuliahController::class, 'index'])->name('dosen.mata-kuliah.index');
    Route::get('dosen/mata-kuliah/{id}', [App\Http\Controllers\Dosen\MataKuliahController::class, 'show'])->name('dosen.mata-kuliah.show');
    Route::get('dosen/mata-kuliah/{id}/edit', [App\Http\Controllers\Dosen\MataKuliahController::class, 'edit'])->name('dosen.mata-kuliah.edit');
    Route::put('dosen/mata-kuliah/{id}', [App\Http\Controllers\Dosen\MataKuliahController::class, 'update'])->name('dosen.mata-kuliah.update');
    Route::resource('dosen/absensi', App\Http\Controllers\Dosen\AbsensiController::class)->names([
        'index' => 'dosen.absensi.index',
        'create' => 'dosen.absensi.create',
        'store' => 'dosen.absensi.store',
        'show' => 'dosen.absensi.show',
        'edit' => 'dosen.absensi.edit',
        'update' => 'dosen.absensi.update',
        'destroy' => 'dosen.absensi.destroy',
    ]);
    Route::resource('dosen/tugas', App\Http\Controllers\Dosen\TugasController::class)->names([
        'index' => 'dosen.tugas.index',
        'create' => 'dosen.tugas.create',
        'store' => 'dosen.tugas.store',
        'edit' => 'dosen.tugas.edit',
        'update' => 'dosen.tugas.update',
        'destroy' => 'dosen.tugas.destroy',
    ]);
});

// Student Attendance
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('student/absensi', [App\Http\Controllers\Student\AbsensiController::class, 'index'])->name('student.absensi.index');
    Route::post('student/absensi', [App\Http\Controllers\Student\AbsensiController::class, 'store'])->name('student.absensi.store');
    
    // Schedule
    Route::get('student/jadwal', [App\Http\Controllers\Student\JadwalController::class, 'index'])->name('student.jadwal.index');
});

require __DIR__.'/auth.php';
