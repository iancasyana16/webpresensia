<?php

namespace App\Http\Controllers\Admin;

use App\Models\Semester;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::all();
        return view('dashboard_admin.semester.index', compact('semesters'));
    }

    public function create()
    {
        return view('dashboard_admin.semester.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'tahun' => 'required|integer',
            'mulai' => 'required|date',
            'selesai' => 'required|date|after:mulai',
        ]);

        Semester::create($request->all());

        return redirect()->route('dashboard-admin-semester')->with('success', 'Semester berhasil ditambahkan.');
    }

    public function edit(Semester $semester)
    {
        return view('semester.edit', compact('semester'));
    }

    public function update(Request $request, Semester $semester)
    {
        $request->validate([
            'nama' => 'required|string',
            'tahun' => 'required|integer',
            'mulai' => 'required|date',
            'selesai' => 'required|date|after:mulai',
        ]);

        $semester->update($request->all());

        return redirect()->route('dashboard-admin-semester')->with('success', 'Semester berhasil diperbarui.');
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();
        return redirect()->route('semester.index')->with('success', 'Semester berhasil dihapus.');
    }
}
