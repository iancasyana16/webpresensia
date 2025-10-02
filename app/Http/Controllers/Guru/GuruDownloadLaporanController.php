<?php

namespace App\Http\Controllers\Guru;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GuruDownloadLaporanController extends Controller
{
    public function downloadRekapSemester($tahun)
    {
        $guru = auth()->user()->guru;

        if (!$guru || !$guru->kelas) {
            abort(403, 'Guru tidak memiliki kelas.');
        }

        $bulanSekarang = date('n');
        $semester = ($bulanSekarang >= 1 && $bulanSekarang <= 6) ? "ganjil" : "genap";

        $rangeBulan = $semester == 1
            ? range(1, 6)   // Januari - Juni
            : range(7, 12); // Juli - Desember

        $siswas = Siswa::where('id_kelas', $guru->kelas->id)->get();

        $rekap = [];

        foreach ($siswas as $siswa) {
            $hadir = $siswa->kehadiran()
                ->whereYear('tanggal', $tahun)
                ->whereIn(\DB::raw('MONTH(tanggal)'), $rangeBulan)
                ->where('status', 'hadir')
                ->count();

            $izin = $siswa->kehadiran()
                ->whereYear('tanggal', $tahun)
                ->whereIn(\DB::raw('MONTH(tanggal)'), $rangeBulan)
                ->where('status', 'izin')
                ->count();

            $alfa = $siswa->kehadiran()
                ->whereYear('tanggal', $tahun)
                ->whereIn(\DB::raw('MONTH(tanggal)'), $rangeBulan)
                ->where('status', 'alfa')
                ->count();

            $rekap[] = [
                'nis' => $siswa->nis,
                'nama' => $siswa->nama,
                'hadir' => $hadir,
                'izin' => $izin,
                'alfa' => $alfa,
            ];
        }

        $pdf = Pdf::loadView('dashboard_guru.laporan.rekapSemester', [
            'rekapSemester' => $rekap, // <-- alias ke nama yang dipakai di view
            'tahun' => $tahun,
            'semester' => $semester,
            'guru' => $guru,
        ])->setPaper('a4', 'portrait');

        return $pdf->download("Rekap-Kehadiran-Semester{$semester}-{$tahun}.pdf");
    }

}
