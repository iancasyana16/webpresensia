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

        $kelas = Kelas::with('wali_kelas')
            ->when($query, function ($q) use ($query) {
                $q->where('nama_kelas', 'like', '%' . $query . '%')
                    ->orWhereHas('wali_kelas', function ($q) use ($query) {
                        $q->where('nama_guru', 'like', '%' . $query . '%');
                    });
            })
            ->orderBy('nama_kelas', 'asc')
            ->paginate(6);

        return view('dashboard_admin.kelas.index', [
            'title' => 'Manajemen Data Kelas',
            'kelas' => $kelas,
            'search' => $query
        ]);
    }

    public function create()
    {
        $waliKelas = Guru::where('wali_kelas', false)->get();
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
        ]);

        Kelas::create(
            [
                'nama_kelas' => $validated['nama_kelas'],
                'id_guru' => $validated['wali_kelas'],
            ]
        );

        $waliKelas = Guru::find($validated['wali_kelas']);
        // dd($waliKelas);

        if($waliKelas) {
            Guru::where('id', $validated['wali_kelas'])->update(['wali_kelas' => true]);
        }

        return redirect()->route('dashboard-admin-kelas')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kelas)
    {
        $gurus = Guru::all();
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
        ]);

        $kelas->update([
            'nama_kelas' => $validated['nama_kelas'],
            'id_guru' => $validated['wali_kelas'],
        ]);

        return redirect()->route('dashboard-admin-kelas')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas)
    {
        Kelas::destroy($kelas->id);

        return redirect()->route('dashboard-admin-kelas')->with('success', 'Data kelas berhasil dihapus.');
    }
}
