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
            'canusercarryover' => 'yes',
            'canpartial' => 'partial',
            'needservicedays' => '90',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=2
        DB::table('leavetypes')->insert([
            'name' => 'Sick Leave SC',
            'value' => '4',
            'issicksc'=>'yes',
            'needscomment'=>'yes',
            'needsattachment'=>'2',
            'canpartial'=>'partial',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        // id=3
        DB::table('leavetypes')->insert([
            'name' => 'Sick Leave DC',
            'value' => '28',
            'canpartial'=>'partial',
            'needsattachment'=>'1',
            'iscalendardays'=>'yes',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=4
        DB::table('leavetypes')->insert([
            'name' => 'Marriage leave',
            'value' => '5',
            'iscalendardays'=>'yse',
            'needsattachment'=>'1',
            'needservicedays' => '1825',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=5
        DB::table('leavetypes')->insert([
            'name' => 'Maternity leave',
            'value' => '98',
            'iscalendardays'=>'yse',
            'needsattachment'=>'1',
            'needservicedays' => '1825',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=6
        DB::table('leavetypes')->insert([
            'name' => 'Paternity leave',
            'value' => '14',
            'iscalendardays'=>'yse',
            'needsattachment'=>'1',
            'needservicedays' => '1825',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=7
        DB::table('leavetypes')->insert([
            'name' => 'Welfare',
            'value' => '9',
            'needscomment'=>'yes',
            'maxperrequest' => '3',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=8
        DB::table('leavetypes')->insert([
            'name' => 'Pilgrimage',
            'value' => '14',
            'iscalendardays'=>'yse',
            'needsattachment'=>'1',
            'needservicedays' => '1825',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=9
        DB::table('leavetypes')->insert([
            'name' => 'R&R',
            'value' => '0',
            'canoverlap'=>'yse',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=10
        DB::table('leavetypes')->insert([
            'name' => 'Home Leave',
            'value' => '2',
            'canoverlap'=>'yse',
            'maxperrequest'=>'2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // id=11
        DB::table('leavetypes')->insert([
            'name' => 'Unpaid leave',
            'value' => '360',
            'iscalendardays'=>'yes',
            'canpartial'=>'partial',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        // id=12
        DB::table('leavetypes')->insert([
            'name' => 'CTO (Compensatory Time off)',
            'value' => '0',
            'canpartial'=>'hour',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //id=13
        DB::table('leavetypes')->insert([
            'name' => 'Work from home',
            'value' => '5',
            'needscomment'=>'yes',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //id=14
        DB::table('leavetypes')->insert([
            'name' => 'Study leave',
            'value' => '14',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //id=15
        DB::table('leavetypes')->insert([
            'name' => 'Remote Work',
            'value' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //id=16
        DB::table('leavetypes')->insert([
            'name' => 'Other leave',
            'value' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //id=17
        DB::table('leavetypes')->insert([
            'name' => 'Carry over',
            'value' => '0',
            'iscarryover'=>'yes',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //id=18
        DB::table('leavetypes')->insert([
            'name' => 'Long-Term Illness',
            'value' => '270',
            'iscalendardays'=>'yes',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //id=19
        DB::table('leavetypes')->insert([
            'name' => 'Breastfeeding Leave',
            'value' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
