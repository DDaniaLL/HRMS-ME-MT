<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'HR Test',
            'employee_number' => '1001',
            'contract' => 'National',
            'usertype_id' => '2',
            'position' => 'HR Manager',
            'office' => 'CO-Erbil',
            'department' => 'HR',
            'grade' => '4',
            'hradmin' => 'yes',
            'superadmin' => 'yes',
            'joined_date' => '2023-01-01',
            'email' => 'Hr.test@nrc.no',
            'email_verified_at' => now(),
            'password' => Hash::make('hrtest123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
