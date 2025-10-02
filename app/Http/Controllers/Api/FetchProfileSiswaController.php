<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FetchProfileSiswaController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $siswa = Siswa::with(['kelas', 'idCard'])
            ->where('id', $user->siswa->id)
            ->first();

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $siswa->id,
                'id_user' => $user->id,
                'id_guru' => $siswa->kelas->guru->id ?? null,
                'nis' => $siswa->nis,
                'nama_siswa' => $siswa->nama,
                'gender' => $siswa->gender,
                'kelas' => $siswa->kelas->nama ?? null,
                'guru' => $siswa->kelas->guru->nama ?? null,
                'uid' => $siswa->idCard->uid ?? null,
            ]
        ]);
    }


    public function kehadiranSiswa(Request $request)
    {
        $user = $request->user();

        $dataSiswa = $user->siswa;

        if ($dataSiswa) {
            return response()->json([
                'status' => 'success',
                'data' => $dataSiswa->kehadiran
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Data siswa tidak ditemukan'
        ], 404);
    }
}
