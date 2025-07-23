<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = ['nis', 'nama_siswa', 'gender', 'id_kelas', 'id_idCard', 'id_user', 'id_guru'];

    public function user()
    {
        return $this->hasOne(User::class, 'id_user');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
    public function Walikelas()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function idCard()
    {
        // Relasi one-to-one
        return $this->belongsTo(IdCard::class, 'id_idCard');
    }

    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'id_siswa');
    }

    public function izin()
    {
        return $this->hasMany(Izin::class, 'id_siswa');
    }
}