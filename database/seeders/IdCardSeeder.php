<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IdCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $data = [];

        for ($i = 1; $i <= 60; $i++) {
            $data[] = [
                'uid' => strtoupper(Str::random(5)),
                'status' => 'tidak aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('id_cards')->insert($data);
    }
}
