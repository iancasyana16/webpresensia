<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Angkatan extends Model
{
    protected $fillable = [
        'nama',
        'mulai',
        'selesai',
    ];

    public function siswa() {
        return $this->hasMany(Siswa::class, 'id_angkatan');
    }
}
