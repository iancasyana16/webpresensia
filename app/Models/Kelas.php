<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    // protected $table = 'kelas';
    protected $fillable = ['nama_kelas', 'id_guru'];

    public function wali_kelas()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'id_kelas');
    }
}
