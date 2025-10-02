<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\IdCardController;
use App\Http\Controllers\Guru\LaporanController;
use App\Http\Controllers\Admin\BerandaController;
use App\Http\Controllers\Guru\IzinSiswaController;
use App\Http\Controllers\Guru\AbsenSiswaController;
use App\Http\Controllers\Admin\AdminSiswaController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Guru\DownloadPdfController;
use App\Http\Controllers\Admin\AdminAngkatanController;
use App\Http\Controllers\Admin\AdminSemesterController;
use App\Http\Controllers\Guru\PengaturanControllerGuru;
use App\Http\Controllers\Guru\GuruDownloadLaporanController;


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

    Route::get('/dashboard-admin-siswa', [AdminSiswaController::class, 'index'])->name('dashboard-admin-siswa');
    Route::get('/dashboard-admin-test', [SiswaController::class, 'create'])->name('dashboard-admin-test');
    Route::get('/create-siswa', [AdminSiswaController::class, 'createBatch'])->name('create-siswa');
    Route::post('/store-siswa', [SiswaController::class, 'store'])->name('store-siswa');
    Route::get('/edit-siswa/{siswa}', [SiswaController::class, 'edit'])->name('edit-siswa');
    Route::put('/update-siswa/{siswa}', [SiswaController::class, 'update'])->name('update-siswa');
    Route::delete('/delete-siswa/{siswa}', [SiswaController::class, 'destroy'])->name('delete-siswa');
    
    Route::get('/dashboard-admin-idcard', [IdCardController::class, 'index'])->name('dashboard-admin-idCard');
    Route::delete('/delete-idCard/{idCard}', [IdCardController::class, 'destroy'])->name('delete-idCard');

    Route::get('/dashboard-admin-angkatan', [AdminAngkatanController::class, 'index'])->name('dashboard-admin-angkatan');
    Route::get('/create-angkatan', [AdminAngkatanController::class, 'create'])->name('create-angkatan');
    Route::post('/store-angkatan', [AdminAngkatanController::class, 'store'])->name('store-angkatan');
    Route::get('/edit-angkatan/{angkatan}', [AdminAngkatanController::class, 'edit'])->name('edit-angkatan');
    Route::put('/update-angkatan/{angkatan}', [AdminAngkatanController::class, 'update'])->name('update-angkatan');
    Route::delete('/delete-angkatan/{angkatan}', [AdminAngkatanController::class, 'destroy'])->name('delete-angkatan');
    Route::post('/angkatan/{id}/naik-kelas', [AdminAngkatanController::class, 'naikKelas'])->name('naik-kelas');

    Route::get('/dashboard-admin-semester', [AdminSemesterController::class, 'index'])->name('dashboard-admin-semester');
    Route::get('/dashboard-admin-semester/create', [AdminSemesterController::class, 'create'])->name('semester.create');
    Route::post('/dashboard-admin-semester', [AdminSemesterController::class, 'store'])->name('semester.store');

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
    // Route::get('/guru/rekap/semester/{tahun}', [DownloadPdfController::class, 'downloadPdf'])->name('download-pdf');
    Route::get('/guru/rekap/download/{bulan}/{tahun}', [DownloadPdfController::class, 'downloadPDF'])->name('download-rekap-bulanan');
    Route::get('/guru/rekap/semester/{tahun}', [GuruDownloadLaporanController::class, 'downloadRekapSemester'])->name('download-rekap-semester');


    route::get('/dashboard-guru-pengaturan', [PengaturanControllerGuru::class, 'index'])->name('dashboard-guru-pengaturan');
    route::put('/dashboard-guru-pengaturan-update', [PengaturanControllerGuru::class, 'update'])->name('update-profile-guru');
});




Route::resource('angkatan', AdminAngkatanController::class);


Route::get('/siswa', [AdminSiswaController::class, 'index'])->name('siswa.index');
Route::get('/siswa/create-batch', [AdminSiswaController::class, 'createBatch'])->name('siswa.createBatch');
Route::post('/siswa/store-batch', [AdminSiswaController::class, 'storeBatch'])->name('siswa.storeBatch');

Route::get('test', function () {
    return view('test');
});