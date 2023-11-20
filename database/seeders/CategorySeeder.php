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
            ['name' => 'Fruits'],
            ['name' => 'Vegetables'],
            ['name' => 'Dairy'],
            ['name' => 'Eggs'],
            ['name' => 'Meat'],
            ['name' => 'Seafood'],
            ['name' => 'Canned and Packaged Goods'],
            ['name' => 'Snacks'],
            ['name' => 'Condiments and Sauces'],
            ['name' => 'Beverages'],
            ['name' => 'Frozen Foods']
        ];
        DB::table('categories')->insert($categories);
    }
}
