<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TarifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tarifs')->insert([
            [
                'daya' => '900 VA',
                'tarifperkwh' => 1352.00
            ],
            [
                'daya' => '1300 VA',
                'tarifperkwh' => 1444.70
            ],
            [
                'daya' => '2200 VA',
                'tarifperkwh' => 1444.70
            ],
        ]);
    }
}
