<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\IdCard;
use App\Models\Angkatan;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminSiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $siswa = Siswa::with(['kelas', 'idCard'])
            ->when($query, function ($q) use ($query) {
                $q->where('nama', 'like', '%' . $query . '%')
                    ->orWhere('nis', 'like', '%' . $query . '%')
                    ->orWhereHas('kelas', function ($q) use ($query) {
                        $q->where('nama', 'like', '%' . $query . '%');
                    });
            })
            ->orderBy('nis', 'asc')
            ->paginate(10);

        return view('dashboard_admin.siswa.index', [
            'title' => 'Manajemen Data Siswa',
            'siswas' => $siswa,
            'search' => $query
        ]);
    }

    public function createBatch()
    {
        $angkatans = Angkatan::all();
        $kelas = Kelas::all();
        $idCards = IdCard::all();

        return view('dashboard_admin.siswa.test', compact('angkatans', 'kelas', 'idCards'));
    }

    /**
     * Simpan batch siswa:
     * - id_kelas & id_angkatan diambil dari request utama (Solusi 2)
     * - Urutkan siswas by nama (case-insensitive) agar NIS mengikuti abjad
     * - NIS: {tahun_angkatan}{urut 3 digit}, username = NIS
     * - Transaksi + lockForUpdate untuk mencegah duplikasi NIS
     */
    public function storeBatch(Request $request)
    {
        // Validasi input dasar
        $validated = $request->validate([
            'id_angkatan' => 'required|integer|exists:angkatans,id',
            'id_kelas' => 'required|integer|exists:kelas,id',
            'siswas' => 'required|array|min:1',
            'siswas.*.nama' => 'required|string|max:255',
            'siswas.*.gender' => 'required|string|in:Laki-laki,Perempuan',
        ]);

        return DB::transaction(function () use ($request) {

            $idAngkatan = (int) $request->id_angkatan;
            $idKelas = (int) $request->id_kelas;

            // Ambil tahun dari kolom 'mulai' Angkatan (misal: 2025-01-01 → 2025)
            $angkatan = Angkatan::findOrFail($idAngkatan);
            $tahun = substr($angkatan->mulai, 0, 4);
            // dd($tahun);

            // Urutkan input siswa berdasarkan nama (case-insensitive)
            $siswasInput = collect($request->input('siswas', []))
                ->sortBy(function ($siswa) {
                    return mb_strtolower($siswa['nama'] ?? '');
                }, SORT_NATURAL)
                ->values();

            // Ambil NIS terakhir di angkatan ini untuk menentukan nomor urut berikutnya
            $lastNis = Siswa::where('id_angkatan', $idAngkatan)
                ->lockForUpdate()
                ->orderBy('nis', 'desc')
                ->value('nis');

            // Ambil 4 digit terakhir NIS terakhir sebagai nomor urut, jika belum ada maka mulai dari 0
            $lastNumber = $lastNis ? (int) substr($lastNis, -4) : 0;
            $nextNumber = $lastNumber + 1;

            $result = [];

            $semesterAktif = Semester::where('mulai', '<=', now())
                ->where('selesai', '>=', now())
                ->first();

                // dd($semesterAktif);

            foreach ($siswasInput as $item) {
                // Buat NIS: tahun + nomor urut 3 digit
                $nis = $tahun . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
                // dd($nis);

                // Buat user baru dengan username = NIS
                $user = User::create([
                    'username' => $nis,
                    'password' => Hash::make($nis), // default password = NIS
                    'role' => 'siswa',
                ]);

                // Buat data siswa
                $siswa = Siswa::create([
                    'nis' => $nis,
                    'nama' => $item['nama'],
                    'gender' => $item['gender'],
                    'id_kelas' => $idKelas,
                    'id_angkatan' => $idAngkatan,
                    'id_semester' => $semesterAktif->id,
                    'id_user' => $user->id,
                ]);
                // dd($siswa);

                $result[] = [
                    'id' => $siswa->id,
                    'nis' => $siswa->nis,
                    'nama' => $siswa->nama,
                    'gender' => $siswa->gender,
                    'kelas' => (string) $idKelas,
                    'username' => $user->username, // username = NIS
                ];

                $nextNumber++;
            }

            // return response()->json([
            //     'message' => 'Sukses Menambahkan Data Siswa.',
            //     'data' => $result,
            // ], 201);

            return redirect()->route('dashboard-admin-siswa')->with('success', 'Sukses Menambahkan Data Siswa.');
        });
    }


}
