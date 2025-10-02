<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = ['nis', 'nama', 'id_angkatan', 'id_semester', 'gender', 'id_kelas', 'id_card', 'id_user', 'id_guru'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'id_angkatan');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
    // public function Walikelas()
    // {
    //     return $this->belongsTo(Guru::class, 'id_guru');
    // }

    public function idCard()
    {
        // Relasi one-to-one
        return $this->belongsTo(IdCard::class, 'id_card');
    }

    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'id_siswa');
    }

    public function izin()
    {
        return $this->hasMany(Izin::class, 'id_siswa');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester');
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($siswa) {
    //         // Ambil tahun sekarang
    //         $tahun = date('Y');

    //         // Ambil jumlah siswa yang sudah ada di tahun ini
    //         $count = self::whereYear('created_at', $tahun)->count() + 1;

    //         // Format nomor urut 3 digit (001, 002, dst)
    //         $nomorUrut = str_pad($count, 3, '0', STR_PAD_LEFT);

    //         // Gabungkan tahun + nomor urut → contoh: 2025001
    //         $siswa->nis = $tahun . $nomorUrut;
    //     });
    // }
}