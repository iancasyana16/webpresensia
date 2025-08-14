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
        $kelas = Auth::user()->guru->kelas ?? null;

        if (!$kelas) {
            return view('dashboard_guru.absen.index', [
                'title' => 'Absen Siswa',
                'siswas' => [],
                'kehadiranMap' => [],
                'message' => 'Anda belum ditugaskan sebagai wali kelas.',
            ]);
        }

        $siswas = $kelas->siswa;
        $today = now()->toDateString();

        $kehadiranHariIni = Kehadiran::whereDate('waktu_tap', $today)
            ->whereIn('id_siswa', $siswas->pluck('id')) // ✅ fix
            ->get();

        $kehadiranMap = $kehadiranHariIni->keyBy('id_siswa');

        return view('dashboard_guru.absen.index', [
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
        $kelas = auth()->user()->guru->kelas->id ?? null;
        return view('dashboard_guru.absen.create', [
            'siswa' => $siswa,
            'guruId' => $guruId,
            'kelas' => $kelas,
        ]);
    }

    public function store(Request $request)
    {
        // dd('MASUK STORE', $request->all());   
        $validated = $request->validate([
            'id_siswa' => 'required',
            'id_kelas' => 'required',
            'waktu_tap' => 'required',
            'status' => 'required',
            'catatan' => 'nullable|string|max:255',
        ]);
        // dd($request->all());

        Kehadiran::create($validated);

        return redirect()->route('dashboard-guru-absen')->with('success', 'Absen manual berhasil disimpan.');
    }
}