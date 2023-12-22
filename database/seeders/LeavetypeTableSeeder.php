<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeavetypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // id=1
        DB::table('leavetypes')->insert([
            'name' => 'Annual leave',
            'value' => '20',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=2
        DB::table('leavetypes')->insert([
            'name' => 'Annual leave - First half',
            'value' => '20',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=3
        DB::table('leavetypes')->insert([
            'name' => 'Annual leave - Second half',
            'value' => '20',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=4
        DB::table('leavetypes')->insert([
            'name' => 'Sick Leave SC',
            'value' => '4',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //id=5
        DB::table('leavetypes')->insert([
            'name' => 'Sick Leave SC - First half',
            'value' => '12',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //id=6
        DB::table('leavetypes')->insert([
            'name' => 'Sick Leave SC - Second half',
            'value' => '12',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=7
        DB::table('leavetypes')->insert([
            'name' => 'Sick Leave DC',
            'value' => '28',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // id=8
        DB::table('leavetypes')->insert([
            'name' => 'Sick Leave DC - First half',
            'value' => '28',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=9
        DB::table('leavetypes')->insert([
            'name' => 'Sick Leave DC - Second half',
            'value' => '28',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=10
        DB::table('leavetypes')->insert([
            'name' => 'Marriage leave',
            'value' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=11
        DB::table('leavetypes')->insert([
            'name' => 'Maternity leave',
            'value' => '98',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=12
        DB::table('leavetypes')->insert([
            'name' => 'Paternity leave',
            'value' => '14',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=13
        DB::table('leavetypes')->insert([
            'name' => 'Welfare',
            'value' => '3',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=14
        DB::table('leavetypes')->insert([
            'name' => 'Pilgrimage',
            'value' => '14',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=15
        DB::table('leavetypes')->insert([
            'name' => 'R&R',
            'value' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=16
        DB::table('leavetypes')->insert([
            'name' => 'Home Leave',
            'value' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=17
        DB::table('leavetypes')->insert([
            'name' => 'Unpaid leave',
            'value' => '360',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=18
        DB::table('leavetypes')->insert([
            'name' => 'Unpaid leave - First half',
            'value' => '360',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=19
        DB::table('leavetypes')->insert([
            'name' => 'Unpaid leave - Second half',
            'value' => '360',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=20
        DB::table('leavetypes')->insert([
            'name' => 'CTO (Compensatory Time off)',
            'value' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=21 just for having it as an option when submitting leaves, the balance is irreveleant as it should be from id18
        DB::table('leavetypes')->insert([
            'name' => 'CTO (Compensatory Time off) - hours',
            'value' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //id=22
        DB::table('leavetypes')->insert([
            'name' => 'Work from home',
            'value' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //id=23
        DB::table('leavetypes')->insert([
            'name' => 'Study leave',
            'value' => '14',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //id=24
        DB::table('leavetypes')->insert([
            'name' => 'Remote Work',
            'value' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //id=25
        DB::table('leavetypes')->insert([
            'name' => 'Other leave',
            'value' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //id=26
        DB::table('leavetypes')->insert([
            'name' => 'Carry over',
            'value' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //id=27
        DB::table('leavetypes')->insert([
            'name' => 'Long-Term Illness',
            'value' => '270',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //id=28
        DB::table('leavetypes')->insert([
            'name' => 'Breastfeeding Leave',
            'value' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
