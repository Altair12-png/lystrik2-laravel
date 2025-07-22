<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_pelanggan';

    protected $fillable = [
        'username',
        'password',
        'nomor_kwh',
        'nama_pelanggan',
        'alamat',
        'id_tarif',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi: Satu Pelanggan memiliki satu Tarif
    public function tarif()
    {
        return $this->belongsTo(Tarif::class, 'id_tarif');
    }

    // Relasi: Satu Pelanggan memiliki banyak Penggunaan
    public function penggunaans()
    {
        return $this->hasMany(Penggunaan::class, 'id_pelanggan');
    }

    // Relasi: Satu Pelanggan memiliki banyak Tagihan
    public function tagihans()
    {
        return $this->hasMany(Tagihan::class, 'id_pelanggan');
    }
}