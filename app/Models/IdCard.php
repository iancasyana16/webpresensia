<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class IdCard extends Model
{
    protected $fillable = ['uid', 'status'];

    public function siswa()
    {
        // Relasi one-to-one (inverse)
        return $this->hasOne(Siswa::class, 'id_idCard');
    }
}