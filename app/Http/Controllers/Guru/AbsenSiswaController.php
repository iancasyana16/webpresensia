<?php

namespace App\Http\Controllers\Guru;

use App\Models\Siswa;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AbsenSiswaController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;

        // Cek apakah guru punya kelas
        // if (!$guru || !$guru->kelas) {
        //     return view('dashboard_guru.absen.index', [
        //         'title' => 'Absen Siswa',
        //         'siswas' => collect(),
        //         'kehadiranMap' => collect(),
        //     ]);
        // }

        // Ambil semua siswa di kelas guru tersebut
        $siswas = $guru->kelas->siswas;

        // Ambil kehadiran siswa hari ini
        $today = now()->toDateString();

        $kehadiranHariIni = Kehadiran::whereDate('waktu_tap', $today)
            ->whereIn('id_siswa', $siswas->pluck('id'))
            ->get();

        // Index berdasarkan id_siswa supaya lookup cepat di blade
        $kehadiranMap = $kehadiranHariIni->keyBy('id_siswa');

        return view('dashboard_guru.absen.index', 
        [
            'title' => 'Absen Siswa',
            'siswas' => $siswas,
            'kehadiranMap' => $kehadiranMap,
        ]);
    }

    public function create(Request $request)
    {
        // Method ini bisa digunakan untuk menampilkan form absen manual jika diperlukan
        // dd(auth()->id());
        $siswa = Siswa::findOrFail($request->query('id')); // misalnya pakai query
        $guruId = auth()->user()->guru->id ?? 1;
        $perekamId = auth()->id();
        return view('dashboard_guru.absen.create', [
            'siswa' => $siswa,
            'guruId' => $guruId,
            'perekamId' => $perekamId,
        ]);
    }

    public function store(Request $request)
    {
        // dd('MASUK STORE', $request->all());   
        $validated = $request->validate([
            'id_siswa' => 'required',
            'id_guru' => 'required',
            'id_perekam' => 'required',
            // 'tipe_kehadiran' => 'required',
            'waktu_tap' => 'required',
            'status' => 'required',
            'catatan' => 'nullable|string|max:255',
        ]);
        // dd($request->all());

        $kehadiran = Kehadiran::create($validated);

        // return response()->json([
        //     'message' => 'Absen manual berhasil dicatat.',
        //     'data' => $kehadiran,
        // ], 201);

        return redirect()->route('dashboard-guru-absen')->with('success', 'Absen manual berhasil disimpan.');
    }
}