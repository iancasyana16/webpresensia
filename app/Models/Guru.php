<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = [
        'nip', 
        'nama', 
        'gender', 
        'mapel', 
        'id_user',
    ];

    // protected $table = 'guru';

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'id_guru');
    }

    public function izin()
    {
        return $this->hasMany(Izin::class, 'id_guru');
    }

}
