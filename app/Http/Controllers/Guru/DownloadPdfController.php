<?php

namespace App\Http\Controllers\Guru;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class DownloadPdfController extends Controller
{
    public function downloadPDF(Request $request)
    {
        $bulan = $request->bulan ?? date('n'); // ✅ angka bulan
        $tahun = $request->tahun ?? date('Y');
        // dd($bulan, $tahun);
        $preview = $request->preview ?? false;

        $guru = auth()->user()->guru;

        $siswaKelas = Siswa::where('id_kelas', $guru->kelas->id)->get();
        // dd($siswaKelas);
        $rekap = $siswaKelas->map(function ($siswa) use ($bulan, $tahun) {
            $hadir = $siswa->kehadiran()->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)->where('status', 'hadir')->count();

            $izin = $siswa->kehadiran()->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)->where('status', 'izin')->count();

            $alfa = $siswa->kehadiran()->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)->where('status', 'alfa')->count();

            logger("Siswa {$siswa->nama} - Hadir: $hadir, Izin: $izin, Alfa: $alfa");

            return [
                'nis' => $siswa->nis,
                'nama' => $siswa->nama,
                'hadir' => $hadir,
                'izin' => $izin,
                'alfa' => $alfa,
            ];
        });

        $pdf = Pdf::loadView('dashboard_guru.laporan.rekapBulanan', compact('rekap', 'bulan', 'tahun', 'guru'));

        return $preview
            ? $pdf->stream("preview-rekap-kehadiran-{$bulan}-{$tahun}.pdf")
            : $pdf->download("rekap-kehadiran-{$bulan}-{$tahun}.pdf");
    }



    public function downloadRekap($bulan, $tahun)
    {
        $guru = auth()->user()->guru;

        // ambil siswa yang berada di kelas wali guru tsb
        $siswas = Siswa::where('id_kelas', $guru->kelas->id)->get();

        $rekap = [];

        foreach ($siswas as $siswa) {
            $hadir = $siswa->kehadiran()
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->where('status', 'hadir')->count();

            $izin = $siswa->kehadiran()
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->where('status', 'izin')->count();

            $alfa = $siswa->kehadiran()
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->where('status', 'alfa')->count();

            $rekap[] = [
                'nis' => $siswa->nis,
                'nama' => $siswa->nama,
                'hadir' => $hadir,
                'izin' => $izin,
                'alfa' => $alfa,
            ];
        }

        // dd($rekap, $bulan, $tahun, $guru);

        // return view('dashboard_guru.laporan.pdf', compact('rekap', 'bulan', 'tahun', 'guru'));


        $pdf = Pdf::loadView('dashboard_guru.laporan.pdf', compact('rekap', 'bulan', 'tahun', 'guru'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("Rekap-Kehadiran-{$bulan}-{$tahun}.pdf");
    }
}
