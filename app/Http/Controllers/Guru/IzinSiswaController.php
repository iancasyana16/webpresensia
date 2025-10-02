<?php

namespace App\Http\Controllers\Guru;

use App\Models\Izin;
use App\Models\Siswa;
use App\Models\Kehadiran;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IzinSiswaController extends Controller
{
    public function index()
    {
        $guru = auth()->user()->guru ?? null;
        // dd($kelas);

        if (!$guru) {
            return view('dashboard_guru.absen.index', [
                'message' => 'Tidak ada siswa dalam kelas yang diampu.',
            ]);
        }

        $izins = Izin::with('guru')
            ->where('id_guru', $guru->id)
            ->orderBy('status')
            ->get();

        return view('dashboard_guru.izin.index', compact('izins'));
    }

    public function show($id)
    {
        $siswa = Siswa::all();
        $izin = Izin::with('siswa')->findOrFail($id);
        return view('dashboard_guru.izin.show', compact('izin', 'siswa'));
    }

    public function detail()
    {
        $izinList = Izin::with('siswa')->orderByDesc('created_at')->get();
        return view('dashboard_guru.izin.show', compact('izinList'));
    }

    public function terimaIzin($id)
    {

        $izin = Izin::findOrFail($id);
        $kelas = auth()->user()->guru->kelas;
        // dd($kelas);
        $izin->status = 'diterima';
        $izin->save();
        // $siswa = Siswa::findOrFail($izin->id_siswa);
        Kehadiran::create([
            'id_siswa' => $izin->id_siswa,
            'id_perekam' => auth()->user()->id,
            'waktu_tap' => $izin->tanggal_izin,
            'id_kelas' => $kelas->id,
            'status' => 'izin', // ditolak, jadi dianggap tidak hadir
        ]);

        // dd($test);

        return redirect()->route('dashboard-guru-izin')->with('success', 'Izin disetujui.');
    }

    public function tolakIzin($id)
    {
        $izin = Izin::findOrFail($id);
        // dd($izin);
        $kelas = auth()->user()->guru->kelas;
        $izin->status = 'ditolak';
        $izin->save();
        // $siswa = Siswa::findOrFail($izin->id_siswa);

        Kehadiran::create([
            'id_siswa' => $izin->id_siswa,
            'id_perekam' => auth()->user()->id,
            'id_kelas' => $kelas->id,
            'waktu_tap' => $izin->tanggal_izin,
            'status' => 'alfa', // ditolak, jadi dianggap tidak hadir
        ]);

        return redirect()->route('dashboard-guru-izin')->with('success', 'Izin ditolak.');
    }

}
