<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'password',

        'nama_admin',
        'id_level',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi: Satu User memiliki satu Level
    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level');
    }

    // Relasi: Satu User bisa melakukan banyak Pembayaran
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'id_user');
    }
}