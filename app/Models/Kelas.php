<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    // protected $table = 'kelas';
    protected $fillable = ['nama', 'tingkat', 'id_guru'];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_kelas');
    }
}
