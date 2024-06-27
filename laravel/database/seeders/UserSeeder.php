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
                'name' =>  'Người quản lí 1',
                'email' => 'manager@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('25052002'),
                'role' => User::ROLE_MANAGER,
                'remember_token' => Str::random(10),
            ],
            [
                'name' =>  'Nhà cung cấp 1',
                'email' => 'supplier@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('25052002'),
                'role' => User::ROLE_SUPPLIER,
                'remember_token' => Str::random(10),
            ],
            [
                'name' =>  'Nhân viên 1',
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
                'address' => 'Giáp Bát, Hà Nội, Việt Nam',
                'phone_contact' => '0366125502'
            ],
            [
                'address' => 'Cầu Giấy, Hà Nội, Việt Nam',
                'phone_contact' => '0949352156'
            ],
        ];
        DB::table('stores')->insert($store);

        DB::table('managers')->truncate();
        $manager = [
            [
                'user_id' =>  2,
                'store_id' => 1,
            ],
        ];
        DB::table('managers')->insert($manager);

        DB::table('staffs')->truncate();
        $staff = [
            [
                'user_id' =>  4,
                'store_id' => 1,
            ],
        ];
        DB::table('staffs')->insert($staff);
    }
}
