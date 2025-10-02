<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable = ['nama', 'tahun', 'mulai', 'selesai'];

    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class, 'id_semester');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_semester');
    }
}
