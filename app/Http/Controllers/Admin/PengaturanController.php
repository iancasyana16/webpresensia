<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PengaturanController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = auth()->user();

        // Ambil data admin berdasarkan user login
        $admin = Admin::where('id_user', $user->id)->first();

        return view('dashboard_admin.pengaturan.index', [
            'title' => 'Edit Data Admin',
            'admin' => $admin,
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        // dd('sampe sini ga ya?');
        $user = auth()->user();
        $admin = Admin::where('id_user', $user->id)->first();
        // dd($user, $admin);

        $validated = $request->validate([
            'nama_admin' => 'required|string|max:255',
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
        $admin->nama_admin = $validated['nama_admin'];
        $admin->save();

        return redirect()->route('dashboard-admin-pengaturan')->with('success', 'Data admin berhasil diperbarui.');
    }

}
