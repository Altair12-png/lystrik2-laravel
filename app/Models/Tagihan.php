<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihans';
    protected $primaryKey = 'id_tagihan';
    protected $fillable = ['id_penggunaan', 'id_pelanggan', 'bulan', 'tahun', 'jumlah_meter', 'status'];

    // Relasi: Satu Tagihan berasal dari satu Penggunaan
    public function penggunaan()
    {
        return $this->belongsTo(Penggunaan::class, 'id_penggunaan');
    }

    // Relasi: Satu Tagihan dimiliki oleh satu Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    // Relasi: Satu Tagihan memiliki satu Pembayaran
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_tagihan');
    }
}