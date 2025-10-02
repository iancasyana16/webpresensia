<?php

namespace App\Http\Controllers\Admin;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $kelas = Kelas::with('guru')
            ->when($query, function ($q) use ($query) {
                $q->where('nama', 'like', '%' . $query . '%')
                    ->orWhereHas('guru', function ($q) use ($query) {
                        $q->where('nama', 'like', '%' . $query . '%');
                    });
            })
            ->orderBy('nama', 'asc')
            ->paginate(6);
        // $kelas = Kelas::get();

        return view('dashboard_admin.kelas.index', [
            'title' => 'Manajemen Data Kelas',
            'kelas' => $kelas,
            'search' => $query
        ]);
    }

    public function create()
    {
        $waliKelas = Guru::all();
        return view(
            'dashboard_admin.kelas.create',
            [
                'title' => 'Tambah Data Kelas',
                // 'gurus' => $gurus,
                // 'kelas' => $kelas,
                'waliKelas' => $waliKelas,
            ]
        );
    }

    public function store(Request $request)
    {
        // dd('masuk stor');
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'wali_kelas' => 'required|exists:gurus,id',
            'tingkat' => 'nullable'
        ]);

        // dd($request->all());

        Kelas::create(
            [
                'nama' => $validated['nama_kelas'],
                'id_guru' => $validated['wali_kelas'],
                'tingkat' => $validated['tingkat'],
            ]
        );

        return redirect()->route('dashboard-admin-kelas')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kelas)
    {
        $gurus = Guru::all();
        // dd($gurus);
        return view('dashboard_admin.kelas.edit', [
            'kelas' => $kelas,
            'gurus' => $gurus,
        ]);
    }

    public function update(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'wali_kelas' => 'required|exists:gurus,id',
            'tingkat' => 'nullable|integer|min:1|max:6',
        ]);

        // Ambil ID guru lama sebelum update
        // Update data kelas
        $kelas->update([
            'nama' => $validated['nama_kelas'],
            'id_guru' => $validated['wali_kelas'],
            'tingkat' => $validated['tingkat'],
        ]);

        return redirect()->route('dashboard-admin-kelas')->with('success', 'Data kelas berhasil diperbarui.');
    }


    public function destroy(Kelas $kelas)
    {
        // dd($kelas->siswa()->exists());
        // dd($kelas);

        if ($kelas->siswa()->exists()) {
            return redirect()->route('dashboard-admin-kelas')->with('error', 'Data kelas tidak dapat dihapus karena memiliki siswa.');
        }

        $kelas->delete();

        return redirect()->route('dashboard-admin-kelas')->with('success', 'Data kelas berhasil dihapus.');
    }
}
