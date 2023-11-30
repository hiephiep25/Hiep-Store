<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('discounts')->truncate();
        $discounts  = [
            [
                'code' => '123qaz',
                'name' =>  'Black Friday',
                'value' => '50',
                'description' => 'Black Friday săn sale ngập tràn!',
                'quantity' => '',
            ],
        ];
        DB::table('discounts')->insert($discounts);
    }
}
