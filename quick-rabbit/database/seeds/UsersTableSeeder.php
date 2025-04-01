<?php

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
        DB::table('tbl_users')->insert([
            'setting_id' => 1,
            'role_id' => 1,
            'first_name' => 'Mr',
            'last_name' => 'Admin',
            'type' => 'Admin',
            'email' => 'admin@doorsoft.co',
            'mobile' => '0123456789',
            'password' => Hash::make('123456'),
        ]);
    }
}
