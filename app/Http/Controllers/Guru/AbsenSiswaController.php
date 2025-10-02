<?php

namespace App\Http\Controllers\Guru;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Semester;
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

        $kehadiranHariIni = Kehadiran::whereDate('tanggal', $today)
            ->whereIn('id_siswa', $siswas->pluck('id')) // ✅ fix
            ->get();

        $kehadiranMap = $kehadiranHariIni->keyBy('id_siswa');

        // dd($siswas);

        return view('dashboard_guru.absen.index', [
            'title' => 'Absen Siswa',
            'siswas' => $siswas,
            'guru' => Auth::user()->guru,
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
        // 1. Ambil semester aktif otomatis
        $semesterAktif = Semester::whereDate('mulai', '<=', now())
            ->whereDate('selesai', '>=', now())
            ->first();

            // dd($semesterAktif);

        if (!$semesterAktif) {
            // dd('Belum ada semester aktif, silakan buat semester dulu.');
            return redirect()->route('dashboard-guru-absen')->with('success', 'Belum ada semester aktif, silakan buat semester dulu.');
        }

        // 2. Validasi input dari request
        $validated = $request->validate([
            'id_siswa' => 'required|exists:siswas,id',
            'status' => 'required|in:hadir,izin,alfa',
            'catatan' => 'nullable|string|max:255',
        ]);

        // 3. Tambahkan otomatis field yang tidak dikirim dari form
        $validated['id_semester'] = $semesterAktif->id;
        $validated['tanggal'] = now()->toDateString();
        $validated['jam'] = now()->toTimeString();

        // 4. Simpan data
        Kehadiran::create($validated);

        return redirect()->route('dashboard-guru-absen')->with('success', 'Absen manual berhasil disimpan.');
    }
}