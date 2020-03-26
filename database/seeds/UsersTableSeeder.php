<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'id' => 1,
            'name' => 'System Admin',
            'username' => 'admin@help',
            'password' => bcrypt('randi92@help'),
            'is_agent' => false
        ]);
    }
}
