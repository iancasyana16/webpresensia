<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\IdCardController;
use App\Http\Controllers\Admin\BerandaController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Guru\IzinSiswaController;
use App\Http\Controllers\Guru\AbsenSiswaController;
use App\Http\Controllers\Guru\DownloadPdfController;
use App\Http\Controllers\Guru\LaporanController;
use App\Http\Controllers\Guru\PengaturanControllerGuru;


Route::get('/', [LoginController::class, 'showLoginForm'])->name('loginPage');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/dashboard-admin-home', [BerandaController::class, 'index'])->name('dashboard-admin-home');

    Route::get('/dashboard-admin-guru', [GuruController::class, 'index'])->name('dashboard-admin-guru');
    Route::get('/create-guru', [GuruController::class, 'create'])->name('create-guru');
    Route::post('/store-guru', [GuruController::class, 'store'])->name('store-guru');
    Route::get('/edit-guru/{guru}', [GuruController::class, 'edit'])->name('edit-guru');
    Route::put('/update-guru/{guru}', [GuruController::class, 'update'])->name('update-guru');
    Route::delete('/delete-guru/{guru}', [GuruController::class, 'destroy'])->name('delete-guru');
    
    Route::get('/dashboard-admin-kelas', [KelasController::class, 'index'])->name('dashboard-admin-kelas');
    Route::get('/create-kelas', [KelasController::class, 'create'])->name('create-kelas');
    Route::post('/store-kelas', [KelasController::class, 'store'])->name('store-kelas');
    Route::get('/edit-kelas/{kelas}', [KelasController::class, 'edit'])->name('edit-kelas');
    Route::put('/update-kelas/{kelas}', [KelasController::class, 'update'])->name('update-kelas');
    Route::delete('/delete-kelas/{kelas}', [KelasController::class, 'destroy'])->name('delete-kelas');

    Route::get('/dashboard-admin-pengaturan', [PengaturanController::class, 'index'])->name('dashboard-admin-pengaturan');
    Route::put('/update-admin', [PengaturanController::class, 'update'])->name('update-admin');

    Route::get('/dashboard-admin-siswa', [SiswaController::class, 'index'])->name('dashboard-admin-siswa');
    Route::get('/create-siswa', [SiswaController::class, 'create'])->name('create-siswa');
    Route::post('/store-siswa', [SiswaController::class, 'store'])->name('store-siswa');
    Route::get('/edit-siswa/{siswa}', [SiswaController::class, 'edit'])->name('edit-siswa');
    Route::put('/update-siswa/{siswa}', [SiswaController::class, 'update'])->name('update-siswa');
    Route::delete('/delete-siswa/{siswa}', [SiswaController::class, 'destroy'])->name('delete-siswa');
    
    Route::get('/dashboard-admin-idcard', [IdCardController::class, 'index'])->name('dashboard-admin-idCard');
    Route::delete('/delete-idCard/{idCard}', [IdCardController::class, 'destroy'])->name('delete-idCard');
});

Route::middleware(['auth', RoleMiddleware::class . ':guru'])->group(function () {
    Route::get('/dashboard-guru-absen', [AbsenSiswaController::class, 'index'])->name('dashboard-guru-absen');
    Route::get('/create-absen', [AbsenSiswaController::class, 'create'])->name('create-absen');
    Route::post('/store-absen', [AbsenSiswaController::class, 'store'])->name('store-absen');

    Route::get('/dashboard-guru-izin', [IzinSiswaController::class, 'index'])->name('dashboard-guru-izin');
    Route::get('/dashboard/guru/izin/{id}', [IzinSiswaController::class, 'show'])->name('dashboard-guru-izin-detail');
    Route::patch('/izin/{id}/approve', [IzinSiswaController::class, 'terimaIzin'])->name('terima-izin');
    Route::patch('/izin/{id}/reject', [IzinSiswaController::class, 'tolakIzin'])->name('tolak-izin');
    
    Route::get('/dashboard-guru-Laporan', [LaporanController::class, 'index'])->name('dashboard-guru-laporan');
    Route::get('/download-rekap-pdf/{bulan}/{tahun}', [DownloadPdfController::class, 'downloadPdf'])->name('download-pdf');
    Route::get('/guru/rekap/download/{bulan}/{tahun}', [DownloadPdfController::class, 'downloadRekap'])->name('rekap.download');
    Route::get('/preview-pdf/{bulan}/{tahun}', [DownloadPdfController::class, 'downloadPdf'])->name('preview-pdf');

    route::get('/dashboard-guru-pengaturan', [PengaturanControllerGuru::class, 'index'])->name('dashboard-guru-pengaturan');
    route::put('/dashboard-guru-pengaturan-update', [PengaturanControllerGuru::class, 'update'])->name('update-profile-guru');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
