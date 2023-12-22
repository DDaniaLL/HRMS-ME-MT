<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfficeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('offices')->insert([
            'name' => 'AO2',
            'description' => 'Country Office',
            'isco' => 'yes',
        ]);

        DB::table('offices')->insert([
            'name' => 'AO3',
            'description' => 'Aleppo',
            'isco' => 'no',
        ]);
        DB::table('offices')->insert([
            'name' => 'AO4',
            'description' => 'Damascus',
            'isco' => 'no',
        ]);
        DB::table('offices')->insert([
            'name' => 'AO6',
            'description' => 'Qamishli',
            'isco' => 'no',
        ]);
        DB::table('offices')->insert([
            'name' => 'AO7',
            'description' => 'Homs',
            'isco' => 'no',
        ]);

    }
}
