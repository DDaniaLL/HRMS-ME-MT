<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsertypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usertypes')->insert([
            'name' => 'staff',
        ]);

        DB::table('usertypes')->insert([
            'name' => 'linemanager',
        ]);

    }
}
