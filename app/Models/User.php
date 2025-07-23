<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    protected $casts = ['password' => 'hashed'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function guru() {
        return $this->hasOne(Guru::class, 'id_user');
    }
    public function admin() {
        return $this->hasOne(Admin::class, 'id_user');
    }
    public function siswa() {
        return $this->hasOne(Siswa::class, 'id_user');
    }

    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Cek apakah relasi entity ada isinya
                if ($this->entity) {
                    switch ($this->role) {
                        case 'admin':
                            return $this->entity->nama_admin;
                        case 'guru':
                            return $this->entity->nama_guru;
                        case 'siswa':
                            return $this->entity->nama_siswa;
                        default:
                            return $this->username; // Jika rolenya aneh, tampilkan username
                    }
                }
                // Jika karena suatu hal entity tidak ada, tampilkan username sebagai fallback
                return $this->username;
            },
        );
    }
}
