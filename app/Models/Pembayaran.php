<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';
    protected $primaryKey = 'id_pembayaran';
    protected $fillable = ['id_tagihan', 'id_pelanggan', 'tanggal_pembayaran', 'bulan_bayar', 'biaya_admin', 'total_bayar', 'id_user'];

    // Relasi: Satu Pembayaran terkait dengan satu Tagihan
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'id_tagihan');
    }

    // Relasi: Satu Pembayaran dilakukan oleh satu Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    // Relasi: Satu Pembayaran dicatat oleh satu User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}