<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Drop the table
        DB::table('roles')->delete();
        DB::table('roles')->insert([
            [
                'id' => 1,
                'role_name' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'role_name' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
