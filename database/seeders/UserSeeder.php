<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();
        //
        DB::table('users')->insert([[
            'id' => 1,
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => encrypt('admin123'),
            'phone' => '0987654321',
            'img_id' => 1
        ],]);
    }
}
