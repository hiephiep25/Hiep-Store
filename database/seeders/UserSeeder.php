<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        $users  = [
            [
                'name' =>  'Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('25052002'),
                'role' => User::ROLE_ADMIN,
                'remember_token' => Str::random(10),
            ],
            [
                'name' =>  'Manager',
                'email' => 'manager@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('25052002'),
                'role' => User::ROLE_MANAGER,
                'remember_token' => Str::random(10),
            ]
        ];
        DB::table('users')->insert($users);

        DB::table('managers')->truncate();
        $manager  = [
            [
                'user_id' =>  2,
                'store_name' => 'Hiephiep',
                'store_address' => 'Ha Noi, Viet Nam',
                'store_contact' => '0366125502',
            ],
        ];
        DB::table('managers')->insert($manager);
    }
}
