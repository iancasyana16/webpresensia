<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = [
        'nip', 
        'nama_guru', 
        'gender', 
        'mapel', 
        'id_user',
    ];
    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'id_guru');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_guru');
    }
}
