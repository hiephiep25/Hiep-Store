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
                'name' =>  'Super Manager',
                'email' => 'supermanager@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('25052002'),
                'role' => User::ROLE_SUPER_MANAGER,
                'remember_token' => Str::random(10),
            ],
            [
                'name' =>  'Manager',
                'email' => 'manager@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('25052002'),
                'role' => User::ROLE_MANAGER,
                'remember_token' => Str::random(10),
            ],
            [
                'name' =>  'Supplier',
                'email' => 'supplier@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('25052002'),
                'role' => User::ROLE_SUPPLIER,
                'remember_token' => Str::random(10),
            ],
            [
                'name' =>  'Staff',
                'email' => 'staff@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('25052002'),
                'role' => User::ROLE_STAFF,
                'remember_token' => Str::random(10),
            ]
        ];
        DB::table('users')->insert($users);

        DB::table('stores')->truncate();
        $store  = [
            [
                'address' => 'Hà Nội, Việt Nam',
                'phone_contact' => '0366125502'
            ],
        ];
        DB::table('stores')->insert($store);

        DB::table('managers')->truncate();
        $manager  = [
            [
                'user_id' =>  2,
                'store_id' => 1,
                'phone_number' => '0366125502',
            ],
        ];
        DB::table('managers')->insert($manager);
    }
}
