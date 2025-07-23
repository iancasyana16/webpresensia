<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FetchAttendanceSiswaController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user(); // user dari token login
        $siswa = $user->siswa;    // pastikan relasi User -> Siswa sudah dibuat

        if (!$siswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Siswa tidak ditemukan'
            ], 404);
        }

        $today = Carbon::today('Asia/Jakarta')->toDateString();

        $kehadiran = Kehadiran::where('id_siswa', $siswa->id)
            ->whereDate('created_at', $today)
            ->first();

        if (!$kehadiran) {
            return response()->json([
                'status' => 'success',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'status' => $kehadiran->status,
                'waktu' => $kehadiran->created_at->format('H:i'),
            ],
        ]);
    }
}
