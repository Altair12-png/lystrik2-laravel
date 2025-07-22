<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggunaan extends Model
{
    use HasFactory;

    protected $table = 'penggunaans';
    protected $primaryKey = 'id_penggunaan';
    protected $fillable = ['id_pelanggan', 'bulan', 'tahun', 'meter_awal', 'meter_akhir'];

    // Relasi: Satu Penggunaan dimiliki oleh satu Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    // Relasi: Satu Penggunaan memiliki satu Tagihan
    public function tagihan()
    {
        return $this->hasOne(Tagihan::class, 'id_penggunaan');
    }
}