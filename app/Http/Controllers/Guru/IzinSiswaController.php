<?php

namespace App\Http\Controllers\Guru;

use App\Models\Izin;
use App\Models\Siswa;
use App\Models\Kehadiran;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IzinSiswaController extends Controller
{
    public function index()
    {
        $guruId = auth()->user()->guru->id ?? null;
        // dd($guruId);

        $izins = Izin::with('siswa')
            ->where('id_guru', $guruId)
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
        $izin->status = 'diterima';
        $izin->save();
        $siswa = Siswa::findOrFail($izin->id_siswa);
        Kehadiran::create([
            'id_siswa' => $izin->id_siswa,
            'id_guru' => $siswa->WaliKelas->id,
            'tanggal' => $izin->tanggal_izin,
            'status' => 'izin', // ditolak, jadi dianggap tidak hadir
        ]);

        return redirect()->route('dashboard-guru-izin')->with('success', 'Izin disetujui.');
    }

    public function tolakIzin($id)
    {
        $izin = Izin::findOrFail($id);
        $izin->status = 'ditolak';
        $izin->save();
        $siswa = Siswa::findOrFail($izin->id_siswa);

        Kehadiran::create([
            'id_siswa' => $izin->id_siswa,
            'id_guru' => $siswa->waliKelas->id,
            'tanggal' => $izin->tanggal_izin,
            'status' => 'alfa', // ditolak, jadi dianggap tidak hadir
        ]);

        return redirect()->route('dashboard-guru-izin')->with('success', 'Izin ditolak.');
    }

}
