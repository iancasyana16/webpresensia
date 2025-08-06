<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\IdCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $siswa = Siswa::with(['kelas', 'waliKelas', 'idCard'])
            ->when($query, function ($q) use ($query) {
                $q->where('nama_siswa', 'like', '%' . $query . '%')
                    ->orWhere('nis', 'like', '%' . $query . '%')
                    ->orWhereHas('kelas', function ($q) use ($query) {
                        $q->where('nama_kelas', 'like', '%' . $query . '%');
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

    public function create()
    {
        $kelas = Kelas::all();
        $idCards = IdCard::where('status', 'tidak aktif')->orderBy('uid', 'asc')->get(); // idCard yang belum dipakai

        return view(
            'dashboard_admin.siswa.create',
            [
                'title' => 'Tambah Siswa Baru',
                'kelas' => $kelas,
                'idCards' => $idCards,
            ]
        );
    }

    public function store(Request $request)
    {
        $validasi = $request->validate(
            [
                'nis' => 'required|numeric|unique:siswas,nis',
                'nama_siswa' => 'required|string|max:255',
                'gender' => 'required|in:Laki-laki,Perempuan',
                'kelas' => 'required|exists:kelas,id',
                'idCard' => 'nullable',
            ]
        );

        $user = User::create(
            [
                'username' => $validasi['nis'],
                'password' => bcrypt('password'),
                'role' => 'siswa',
            ]
        );

        if ($user) {

            Siswa::create(
                [
                    'id_user' => $user->id,
                    'nis' => $validasi['nis'],
                    'nama_siswa' => $validasi['nama_siswa'],
                    'gender' => $validasi['gender'],
                    'id_kelas' => $validasi['kelas'],
                    'id_idCard' => $validasi['idCard'] ?? null,
                ]
            );

            if (!empty($validasi['idCard'])) {
                IdCard::where('id', $validasi['idCard'])->update(['status' => 'aktif']);
            }
        }

        return redirect()->route('dashboard-admin-siswa')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::all();
        $idCards = IdCard::where('status', 'tidak aktif')->orderBy('uid', 'asc')->get(); // idCard yang belum dipakai

        return view(
            'dashboard_admin.siswa.edit',
            [
                'title' => 'Edit Data Siswa',
                'kelas' => $kelas,
                'idCards' => $idCards,
                'siswa' => $siswa
            ]
        );
    }

    public function update(Request $request, Siswa $siswa)
    {
        // dd('test');
        $validasi = $request->validate(
            [
                'nis' => 'required|numeric|unique:siswas,nis,' . $siswa->id,
                'nama_siswa' => 'required|string|max:255',
                'gender' => 'required|in:Laki-laki,Perempuan',
                'kelas' => 'required|exists:kelas,id',
                'idCard' => 'nullable',
            ]
        );

        $oldIdCard = $siswa->id_idCard;
        // dd($oldIdCard);

        if (!empty($validasi['idCard'])) {
            if ($oldIdCard && $oldIdCard != $validasi['idCard']) {
                IdCard::where('id', $oldIdCard)->update(['status' => 'tidak aktif']);

                // Aktifkan ID Card baru (selalu dijalankan jika ada ID Card baru)
                IdCard::where('id', $validasi['idCard'])->update(['status' => 'aktif']);
            } 
        }

        $siswa->update(
            [
                'nis' => $validasi['nis'],
                'nama_siswa' => $validasi['nama_siswa'],
                'gender' => $validasi['gender'],
                'id_kelas' => $validasi['kelas'],
                'id_idCard' => $validasi['idCard'],
            ]
        );
        // dd($siswa->update());

        return redirect()->route('dashboard-admin-siswa')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->id_idCard) {
            IdCard::where('id', $siswa->id_idCard)->delete();
        }

        User::destroy($siswa->id_user);
        Siswa::destroy($siswa->id);

        return redirect()->route('dashboard-admin-siswa')->with('success', 'Data siswa berhasil dihapus.');
    }
}
