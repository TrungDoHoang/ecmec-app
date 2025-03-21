<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu trước khi insert
        DB::table('home_contents')->delete();
        //
        DB::table('home_contents')->insert([
            [
                'title_vn' => 'Title VN',
                'title_en' => 'Title EN',
                'content_vn' => 'Content VN',
                'content_en' => 'Content EN',
                'created_by' => 1,
                'updated_by' => 1,
                'is_delete' => 0,
                'img_id' => 1
            ],
        ]);
    }
}
