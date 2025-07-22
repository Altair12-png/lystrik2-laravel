<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    use HasFactory;

    protected $table = 'tarifs';
    protected $primaryKey = 'id_tarif';
    protected $fillable = ['daya', 'tarifperkwh'];

    // Relasi: Satu Tarif memiliki banyak Pelanggan
    public function pelanggans()
    {
        return $this->hasMany(Pelanggan::class, 'id_tarif');
    }
}