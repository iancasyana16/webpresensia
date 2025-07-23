<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthLoginController extends Controller
{

    /**
     * Get the authenticated user details.
     * This route requires authentication with Sanctum token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function user(Request $request)
    {
        // request()->user() akan mengembalikan instance User yang terotentikasi
        return response()->json([
            'user' => [
                'id' => $request->user()->id,
                'username' => $request->user()->username,
                'role' => $request->user()->role,
                // Tambahkan data user lain yang ingin Anda kirim
            ]
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'message' => 'Periksa Username atau Password',
                'errors' => [
                    'credentials' => ['Username atau password tidak cocok.']
                ]
            ], 401); // 401 Unauthorized
        }

        $user = Auth::user();

        // Hapus token lama jika ada (opsional, untuk memastikan hanya ada satu token aktif per perangkat)
        $user->tokens()->delete();

        // Buat token Sanctum baru untuk pengguna
        // 'auth_token' adalah nama token, bisa disesuaikan
        $token = $user->createToken('auth_token')->plainTextToken;

        // Kembalikan respons JSON
        return response()->json([
            'message' => 'Login berhasil!',
            'data' => [
                'id' => $user->id,
                'username' => $user->username,
                'id_siswa' => $user->siswa->id,
                'id_guru' => $user->siswa->Walikelas->id,
                'id_perekam' => $user->siswa->Walikelas->id,
                'id_idCard' => $user->siswa->idCard->uid,
                'role' => $user->role,
                'token' => $token, // Token yang baru dibuat
            ]
        ], 200); // 200 OK
    }
    public function logout(Request $request)
    {
        if ($request->user()) {
            // Hapus token yang sedang digunakan oleh pengguna saat ini
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Logout berhasil.'], 200);
        }

        return response()->json(['message' => 'Tidak ada pengguna yang terotentikasi.'], 401);
    }

}
