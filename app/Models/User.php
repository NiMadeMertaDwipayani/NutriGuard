<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// TAMBAHAN 1: Import Interface JWT
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

// TAMBAHAN 2: Tambahkan "implements JWTSubject"
class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',   // Kode Anda Tetap Aman
        'avatar', // Kode Anda Tetap Aman
    ];

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

    // Relasi: User memiliki Banyak Penyakit (Kode Anda Tetap Aman)
    public function diseases()
    {
        return $this->belongsToMany(Disease::class);
    }

    // TAMBAHAN 3: Dua Method Wajib untuk JWT
    // (Simpan di paling bawah sebelum kurung tutup terakhir)
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
