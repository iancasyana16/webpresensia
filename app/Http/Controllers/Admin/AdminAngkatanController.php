<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Angkatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminAngkatanController extends Controller
{
    public function index()
    {
        $angkatans = Angkatan::latest()->get();
        $title = "Manajemen Data Angkatan";
        return view('dashboard_admin.angkatan.index', compact('angkatans', 'title'));
    }

    public function create()
    {
        $title = "Manajemen Data Angkatan";
        return view('dashboard_admin.angkatan.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'mulai' => 'required|date',
            'selesai' => 'required|date|after_or_equal:mulai',
        ]);

        // dd($request->all());

        Angkatan::create($request->all());

        return redirect()->route('dashboard-admin-angkatan')->with('success', 'Angkatan berhasil ditambahkan');
    }

    public function edit(Angkatan $angkatan)
    {
        return view('angkatan.edit', compact('angkatan'));
    }

    public function update(Request $request, Angkatan $angkatan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tahun_mulai' => 'required|digits:4|integer',
            'tahun_selesai' => 'required|digits:4|integer|gte:tahun_mulai',
        ]);

        $angkatan->update($request->all());

        return redirect()->route('angkatan.index')->with('success', 'Angkatan berhasil diperbarui');
    }

    public function destroy(Angkatan $angkatan)
    {
        $angkatan->delete();
        return redirect()->route('angkatan.index')->with('success', 'Angkatan berhasil dihapus');
    }

    public function naikKelas($id)
    {
        // Pastikan angkatan ada
        $angkatan = Angkatan::findOrFail($id);

        // Ambil semua siswa dari angkatan ini
        $siswas = Siswa::where('id_angkatan', $angkatan->id)->get();

        foreach ($siswas as $siswa) {
            $kelasSekarang = Kelas::find($siswa->id_kelas);

            if ($kelasSekarang) {
                // Cari kelas dengan tingkat lebih tinggi
                $kelasBerikutnya = Kelas::where('tingkat', $kelasSekarang->tingkat + 1)->first();

                if ($kelasBerikutnya) {
                    // Update siswa ke kelas berikutnya
                    $siswa->update([
                        'id_kelas' => $kelasBerikutnya->id,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Semua siswa angkatan ' . $angkatan->nama . ' berhasil naik kelas!');
    }
}
