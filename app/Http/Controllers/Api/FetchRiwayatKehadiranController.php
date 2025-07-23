<?php

namespace App\Http\Controllers\Api;

use App\Models\Kehadiran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class FetchRiwayatKehadiranController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();
        $siswa = $user->siswa;

        if (!$siswa) {
            return response()->json([
                'message' => 'Siswa tidak ditemukan.',
            ], 404);
        }

        $riwayat = $siswa->kehadiran()
            ->whereIn('status', ['hadir', 'alfa'])
            ->orderBy('waktu_tap', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => Carbon::parse($item->waktu_tap)->translatedFormat('l, d F Y'),
                    'status' => $item->status,
                ];
            });

        return response()->json($riwayat);
    }

}
