<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use App\Models\Kehadiran;

class FetchStatistikSiswaController extends Controller
{
    public function index(Request $request)
    {

        $user = $request->user();
        $siswa = $user->siswa;

        if (!$siswa) {
            return response()->json(['status' => 'error', 'message' => 'Siswa tidak ditemukan'], 404);
        }

        $hadir = Kehadiran::where('id_siswa', $siswa->id)
            ->where('status', 'Hadir')
            ->whereMonth('waktu_tap', Carbon::now()->month)
            ->count();
        $izin = Kehadiran::where('id_siswa', $siswa->id)
            ->where('status', 'Izin')
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
        $alfa = Kehadiran::where('id_siswa', $siswa->id)
            ->where('status', 'Alfa')
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'hadir' => $hadir,
                'izin' => $izin,
                'alfa' => $alfa,
            ]
        ]);

    }
}