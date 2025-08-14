<?php

namespace App\Http\Controllers\Admin;

use App\Models\Guru;
use App\Models\IdCard;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Http\Controllers\Controller;

class BerandaController extends Controller
{
    public function index()
    {
        $jumlahSiswa = Siswa::count();
        $jumlahGuru = Guru::count();
        $jumlahKelas = Kelas::count();
        $jumlahIdCard = IdCard::count();
        $title = 'Beranda Admin';

        return view('dashboard_admin.beranda.index', compact('title', 'jumlahSiswa', 'jumlahGuru', 'jumlahKelas', 'jumlahIdCard'));
    }
}
