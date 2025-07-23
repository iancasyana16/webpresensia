<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FetchRiwayatIzinController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $siswa = $user->siswa;

        if (!$siswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Siswa tidak ditemukan.'
            ], 404);
        }

        $riwayatIzin = $siswa->izin() // pastikan relasi izin() ada di model Siswa
            ->orderBy('tanggal_izin', 'desc')
            ->get()
            ->map(function ($izin) {
                return [
                    'tanggal' => Carbon::parse($izin->tanggal_izin)->translatedFormat('l, d F Y'),
                    'alasan' => $izin->alasan,
                    'status' => $izin->status,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $riwayatIzin
        ]);
    }
}
