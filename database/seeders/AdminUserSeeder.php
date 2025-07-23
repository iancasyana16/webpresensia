<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // 1. Buat atau cari profil Admin terlebih dahulu.
        // Metode firstOrCreate() berguna agar tidak ada duplikasi data admin
        // jika seeder ini dijalankan lebih dari satu kali.
        $adminProfile = User::firstOrCreate(
            
            [
                // Data untuk dibuat atau di-update
                'username' => 'admin',
                'password' => Hash::make('password'), // Ganti 'password' dengan password yang lebih aman!
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 2. Buat atau perbarui akun User yang terhubung dengan profil Admin tersebut.
        // Metode updateOrCreate() akan mencari user yang terhubung,
        // lalu memperbaruinya, atau membuatnya jika belum ada.
        $adminProfile->admin()->updateOrCreate(
            [
                'nama_admin' => 'Administrator Utama',
                'id_user' => $adminProfile->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );
    }
}