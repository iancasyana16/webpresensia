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

        $siswa = Siswa::with(['kelas', 'Walikelas', 'idCard'])
            ->where('id', $user->siswa->id)
            ->first();

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $siswa->id,
                'id_user' => $user->id,
                'nis' => $siswa->nis,
                'nama_siswa' => $siswa->nama_siswa,
                'gender' => $siswa->gender,
                'kelas' => $siswa->kelas->nama_kelas ?? null,
                'guru' => $siswa->Walikelas->nama_guru ?? null,
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
