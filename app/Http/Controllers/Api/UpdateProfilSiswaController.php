<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UpdateProfilSiswaController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user->siswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses hanya untuk siswa.'
            ], 403);
        }

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $user->username = $validated['username'];

        if (!empty($validated['password'])) {
            $user->forceFill([
                'password' => Hash::make($validated['password']),
            ]);
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data login siswa berhasil diperbarui.',
            'user' => $user
        ]);
    }

}
