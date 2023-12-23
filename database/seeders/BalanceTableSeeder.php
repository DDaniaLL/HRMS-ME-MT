<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BalanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('balances')->insert([
            'name' => 'Annual leave',
            'leavetype_id' => '1',
            'user_id' => '1',
            'value' => '20',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Sick Leave SC',
            'leavetype_id' => '2',
            'user_id' => '1',
            'value' => '4',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('balances')->insert([
            'name' => 'Sick Leave DC',
            'leavetype_id' => '3',
            'user_id' => '1',
            'value' => '28',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('balances')->insert([
            'name' => 'Marriage leave',
            'leavetype_id' => '4',
            'user_id' => '1',
            'value' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Maternity leave',
            'leavetype_id' => '5',
            'user_id' => '1',
            'value' => '98',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Paternity leave',
            'leavetype_id' => '6',
            'user_id' => '1',
            'value' => '14',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Welfare',
            'leavetype_id' => '7',
            'user_id' => '1',
            'value' => '3',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Pilgrimage',
            'leavetype_id' => '8',
            'user_id' => '1',
            'value' => '14',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'R&R',
            'leavetype_id' => '9',
            'user_id' => '1',
            'value' => '30',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Home Leave',
            'leavetype_id' => '10',
            'user_id' => '1',
            'value' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Unpaid leave',
            'leavetype_id' => '11',
            'user_id' => '1',
            'value' => '300',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'CTO (Compensatory Time off)',
            'leavetype_id' => '12',
            'user_id' => '1',
            'value' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Work from home',
            'leavetype_id' => '13',
            'user_id' => '1',
            'value' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Study leave',
            'leavetype_id' => '14',
            'user_id' => '1',
            'value' => '14',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Remote Work',
            'leavetype_id' => '15',
            'user_id' => '1',
            'value' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Other leave',
            'leavetype_id' => '16',
            'user_id' => '1',
            'value' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Carry over',
            'leavetype_id' => '17',
            'user_id' => '1',
            'value' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Long-Term Illness',
            'leavetype_id' => '18',
            'user_id' => '1',
            'value' => '270',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('balances')->insert([
            'name' => 'Breastfeeding Leave',
            'leavetype_id' => '19',
            'user_id' => '1',
            'value' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
