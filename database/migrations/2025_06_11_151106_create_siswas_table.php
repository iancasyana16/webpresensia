<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique();
            $table->string('nama_siswa');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->foreignId('id_kelas')->constrained('kelas')->onDelete('cascade');
            // $table->foreignId('id_guru')->constrained('gurus')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_idCard')->nullable()->unique()->constrained('id_cards')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};