<?php

namespace App\Http\Controllers\Admin;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        // query diambil dari inputan elemen search di halaman index
        $query = $request->input('search');

        $gurus = Guru::when($query, function ($q) use ($query) {
            $q->where('nama_guru', 'like', '%' . $query . '%')
                ->orWhere('nip', 'like', '%' . $query . '%')
                ->orWhere('mapel', 'like', '%' . $query . '%');
        })->orderBy('nama_guru')->paginate(5);

        return view('dashboard_admin.guru.index', [
            'title' => 'Manajemen Data Guru',
            'gurus' => $gurus, //ketika ada query maka guru akan difilter jika kosong tampil semua data
            'search' => $query
        ]);
    }

    public function create(Guru $guru)
    {
        // $guru = Guru::all(); ini tidak perlu karena kita hanya ingin menampilkan form untuk menambah data guru yang berelasi
        // jika ingin menampilkan data guru yang sudah ada, bisa gunakan $guru = Guru::find($id);
        // namun dalam kasus ini kita hanya ingin menampilkan form untuk menambah data
        // jika ingin menampilkan data guru yang sudah ada, bisa gunakan $guru = Guru::find($id);
        // debug pake dd
        return view(
            'dashboard_admin.guru.create',
            [
                'title' => 'Tambah Data Guru',
                'guru' => $guru
            ]
        );
    }

    public function store(Request $request)
    {
        // Validasi inputan dari form
        // Validasi ini akan memastikan bahwa inputan yang dimasukkan sesuai dengan aturan yang telah ditentukan
        // Jika validasi gagal, maka akan mengembalikan pesan error di halaman index
        $validatedData = $request->validate(
            [
                'nama_guru' => 'required|string|max:255',
                'nip' => 'required|numeric',
                'gender' => 'required|in:Laki-laki,Perempuan',
                'mapel' => 'required',
            ]
        );

        //ini akan membuat user baru dengan role guru dan password default 'password'
        $user = User::create(
            [
                'username' => $validatedData['nama_guru'],
                'password' => Hash::make('password'),
                'role' => 'guru',
            ]
        );

        // Jika user berhasil dibuat, maka kita akan membuat data guru baru
        if($user) {
            Guru::create(
                [
                    'nama_guru' => $validatedData['nama_guru'],
                    'nip' => $validatedData['nip'],
                    'gender' => $validatedData['gender'],
                    'mapel' => $validatedData['mapel'],
                    'id_user' => $user->id,
                ]
            );
        }

        // Setelah data guru berhasil dibuat, kita akan redirect ke halaman index dengan pesan sukses
        return redirect('/dashboard-admin-guru')->with('success', 'Data guru berhasil ditambahkan!');
    }

    public function edit(Guru $guru)
    {
        // mengembalikan view edit guru
        return view(
            'dashboard_admin.guru.edit',
            [
                'title' => 'Edit Data Guru',
                'guru' => $guru,
            ]
        );
    }

    public function update(Request $request, Guru $guru)
    {

        // Validasi inputan dari form
        // Validasi ini akan memastikan bahwa inputan yang dimasukkan sesuai dengan aturan yang telah ditentukan
        // Jika validasi gagal, maka akan mengembalikan pesan error di halaman edit
        $validatedData = $request->validate(
            [
                'nama_guru' => 'required|string|max:255',
                'nip' => 'required|numeric',
                'gender' => 'required|in:Laki-laki,Perempuan',
                'mapel' => 'required',
            ]
        );

        // Update data guru dengan data yang telah divalidasi
        $guru->update(
            [
                'nama_guru' => $validatedData['nama_guru'],
                'nip' => $validatedData['nip'],
                'gender' => $validatedData['gender'],
                'mapel' => $validatedData['mapel'],
            ]
        );

        // setelah data guru berhasil diupdate, kita akan redirect ke halaman index dengan pesan sukses
        return redirect()->route('dashboard-admin-guru')->with('success', 'Data guru berhasil diperbarui!');
    }

    public function destroy(Guru $guru)
    {
        // dd($guru->siswa()->exists());
        // Cek apakah guru masih memiliki siswa
        // Jika masih memiliki siswa, maka tidak bisa dihapus
        // Jika tidak ada siswa yang berelasi, maka bisa dihapus
        // if ($guru->siswa()->exists()) {
        //     return redirect()->back()->with('error', 'Tidak bisa menghapus guru karena masih memiliki siswa.');
        // }

        // Hapus data guru dan user yang berelasi
        // Pertama kita akan menghapus user yang berelasi dengan guru
        // Kemudian kita akan menghapus data guru itu sendiri
        User::destroy($guru->id_user);
        Guru::destroy($guru->id);

        // Setelah data guru berhasil dihapus, kita akan redirect ke halaman index dengan pesan sukses
        return redirect('dashboard-admin-guru')->with('success', 'Data guru berhasil dihapus!');
    }
}