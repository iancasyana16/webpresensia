<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kehadirans', function (Blueprint $table) {
            $table->foreignId('id_perekam')->nullable()->change(); // Ubah kolom id_perekam menjadi nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kehadirans', function (Blueprint $table) {
            $table->foreignId('id_perekam')->nullable(false)->change(); // Kembalikan kolom id_perekam menjadi tidak nullable
        });
    }
};
