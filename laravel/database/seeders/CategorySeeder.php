<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->truncate();
        $categories  = [
            ['name' => 'Hoa quả'],
            ['name' => 'Rau'],
            ['name' => 'Thực phẩm bơ sữa'],
            ['name' => 'Trứng'],
            ['name' => 'Thịt'],
            ['name' => 'Hải sản'],
            ['name' => 'Thực phẩm đóng hộp'],
            ['name' => 'Đồ ăn vặt'],
            ['name' => 'Gia vị và nước sốt'],
            ['name' => 'Đồ uống'],
        ];
        DB::table('categories')->insert($categories);
    }
}
