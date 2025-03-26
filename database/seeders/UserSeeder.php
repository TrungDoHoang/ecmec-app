<?php

namespace Database\Seeders;

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
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
                'phone' => '0987654321',
                'img_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Trung',
                'email' => 'trung@gmail.com',
                'password' => bcrypt('admin123'),
                'phone' => '0987654321',
                'img_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Insert data to user_role table
        DB::table('user_role')->delete();
        DB::table('user_role')->insert([
            [
                'user_id' => 1,
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
