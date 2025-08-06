<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AbsensiRfidController;
use App\Http\Controllers\Api\IzinController;
use App\Http\Controllers\Api\UpdateProfilSiswaController;
use App\Http\Controllers\Api\AuthLoginController;
use App\Http\Controllers\Api\FetchRiwayatIzinController;
use App\Http\Controllers\Api\FetchProfileSiswaController;
use App\Http\Controllers\Api\FetchStatistikSiswaController;
use App\Http\Controllers\Api\FetchAttendanceSiswaController;
use App\Http\Controllers\Api\FetchRiwayatKehadiranController;


Route::post('/login', [AuthLoginController::class, 'login']);
Route::post('/scan-card', [AbsensiRfidController::class, 'processRfidScan']);

Route::middleware('auth:sanctum')->get('/siswa-profile', [FetchProfileSiswaController::class, 'index']);
Route::middleware('auth:sanctum')->get('/siswa-attendance', [FetchAttendanceSiswaController::class, 'index']);
Route::middleware('auth:sanctum')->get('/siswa-statistik', [FetchStatistikSiswaController::class, 'index']);
Route::middleware('auth:sanctum')->get('/siswa-riwayat-kehadiran', [FetchRiwayatKehadiranController::class, 'index']);
Route::middleware('auth:sanctum')->get('/siswa-riwayat-izin', [FetchRiwayatIzinController::class, 'index']);
Route::middleware('auth:sanctum')->post('/siswa-izin', [IzinController::class, 'store']);
Route::middleware('auth:sanctum')->post('/siswa-update-profile', [UpdateProfilSiswaController::class, 'store']);