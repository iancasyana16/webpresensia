<?php

namespace App\Http\Controllers\Guru;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    public function rekapKelas(Request $request)
    {
        $guru = auth()->user()->guru;

        // Ambil siswa dalam kelas yang diampu guru (wali kelas)
        $siswas = $guru->kelas->siswas; // Pastikan relasi Guru -> Kelas -> Siswa sudah dibuat

        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        $rekap = $siswas->map(function ($siswa) use ($bulan, $tahun) {
            $kehadiran = $siswa->kehadiran()
                ->whereMonth('waktu_tap', $bulan)
                ->whereYear('waktu_tap', $tahun)
                ->get();

            return [
                'nis' => $siswa->nis,
                'nama' => $siswa->nama_siswa,
                'hadir' => $kehadiran->where('status', 'hadir')->count(),
                'izin' => $kehadiran->where('status', 'izin')->count(),
                'alfa' => $kehadiran->where('status', 'alfa')->count(),
            ];
        });

        return view('dashboard_guru.izin.laporan', [
            'rekap' => $rekap,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'guru' => $guru
        ]);
    }

    public function index()
    {
        $guru = auth()->user()->guru;
        $siswaIds = $guru->kelas->siswas->pluck('id');
        // dd($siswaIds);

        if (!$siswaIds) {
            return view('dashboard_guru.absen.index', [
                'message' => 'Tidak ada siswa dalam kelas yang diampu.',
            ]);
        }

        $tahun = date('Y');
        // $bulanList = ['07', '08']; // atau generate dinamis
        // $rekapBulanan = [];
        $bulanList = Kehadiran::whereIn('id_siswa', $siswaIds)
            ->whereYear('waktu_tap', $tahun)
            ->selectRaw('MONTH(waktu_tap) as bulan')
            ->distinct()
            ->pluck('bulan')
            ->mapWithKeys(function ($bulan) {
                return [$bulan => Carbon::create()->month($bulan)->translatedFormat('n')];
            })
            ->sortKeys();

        $rekapBulanan = [];

        foreach ($bulanList as $kodeBulan => $namaBulan) {
            $rekapBulanan[$namaBulan] = $this->getRekapData($kodeBulan, $tahun, $guru->id);
        }

        return view('dashboard_guru.laporan.index', compact('rekapBulanan', 'tahun', 'guru'));
    }

    private function getRekapData($bulan, $tahun, $id_kelas)
    {
        // Ambil data siswa wali kelas guru
        $siswas = Siswa::where('id_kelas', $id_kelas)->get();

        $rekap = [];
        foreach ($siswas as $siswa) {
            $kehadiran = Kehadiran::where('id_siswa', $siswa->id)
                ->whereMonth('waktu_tap', $bulan)
                ->whereYear('waktu_tap', $tahun)
                ->get();

            $rekap[] = [
                'nis' => $siswa->nis,
                'nama' => $siswa->nama,
                'hadir' => $kehadiran->where('status', 'hadir')->count(),
                'izin' => $kehadiran->where('status', 'izin')->count(),
                'alfa' => $kehadiran->where('status', 'alfa')->count(),
            ];
        }

        return $rekap;
    }

}

