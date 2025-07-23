<?php

namespace App\Http\Controllers\Api;

use App\Models\Izin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IzinController extends Controller
{
    public function index()
    {
        $izins = Izin::with('siswa', 'guru')->latest()->get();
        return view('izin.index', compact('izins'));
    }

    public function create()
    {
        return view('izin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_siswa' => 'required|exists:siswas,id',
            'id_guru' => 'required|exists:gurus,id',
            'tanggal_izin' => 'required|date',
            'alasan' => 'required|string',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Ambil id_perekam dari Auth jika tersedia, fallback ke request
        $validated['id_perekam'] =  $request->input('id_perekam');

        if (!$validated['id_perekam']) {
            return response()->json(['message' => 'ID perekam tidak valid'], 422);
        }

        // Simpan file jika ada
        if ($request->hasFile('bukti')) {
            $validated['bukti'] = $request->file('bukti')->store('bukti_izin', 'public');
        }

        $izin = Izin::create($validated);

        return response()->json([
            'message' => 'Izin berhasil diajukan',
            'data' => $izin,
        ], 201);
    }

}
