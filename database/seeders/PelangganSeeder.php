<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pelanggans')->insert([
            'username' => 'budi',
            'password' => Hash::make('password'),
            'nomor_kwh' => '12345678901',
            'nama_pelanggan' => 'Budi Santoso',
            'alamat' => 'Jl. Merdeka No. 10, Jakarta',
            'id_tarif' => 1, // ID untuk tarif 900 VA dari TarifSeeder
        ]);
    }
}
