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
            'role_id'   => 1,
            'name'      => 'Md. Shagor Sarder',
            'email'     => 'shagor.sarder.dev@gmail.com',
            'photo'     => 'default.png',
            'password'  => bcrypt('shagor@123')
        ]);
    }
}
