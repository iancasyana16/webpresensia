<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $table = 'kehadirans';
    protected $fillable = ['id_siswa', 'id_kelas', 'waktu_tap', 'status', 'catatan'];
    protected $casts = ['waktu_tap' => 'datetime'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function perekam()
    {
        return $this->belongsTo(User::class, 'id_perekam');
    }

    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'id_guru');
    }
}