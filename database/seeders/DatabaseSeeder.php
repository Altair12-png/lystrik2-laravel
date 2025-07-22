<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder lain sesuai urutan yang benar
        // Level dan Tarif harus dibuat terlebih dahulu sebelum User dan Pelanggan
        // karena ada ketergantungan data (foreign key).
        $this->call([
            LevelSeeder::class,
            TarifSeeder::class,
            UserSeeder::class,
            PelangganSeeder::class,
        ]);
    }
}