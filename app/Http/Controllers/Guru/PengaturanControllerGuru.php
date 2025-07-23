<?php

namespace App\Http\Controllers\Guru;

use App\Models\Guru;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PengaturanControllerGuru extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = auth()->user();

        // Ambil data admin berdasarkan user login
        $guru = Guru::where('id_user', $user->id)->first();

        return view('dashboard_guru.pengaturan.index', [
            'title' => 'Edit Data Guru',
            'guru' => $guru,
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        // dd('sampe sini ga ya?');
        $user = auth()->user();
        $guru = Guru::where('id_user', $user->id)->first();
        // dd($user, $admin);

        $validated = $request->validate([
            'nama_guru' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string',
            'konfirmasi_password' => 'nullable|string',
        ]);

        // Update username
        $user->username = $validated['username'];

        // Update password jika diisi
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        // Update nama admin
        $guru->nama_guru = $validated['nama_guru'];
        $guru->save();

        return redirect()->route('dashboard-guru-pengaturan')->with('success', 'Data admin berhasil diperbarui.');
    }
}
