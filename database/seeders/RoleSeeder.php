<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
// use App\Models\Role; // Aktifkan jika kamu punya Model Role

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'position' => 'owner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'position' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'position' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('categories')->insert([
            [
                'id' => 1,
                'name' => 'Susu Kecik Bubuk',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Susu Besar Cair',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Susu Ibu Hamil',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        User::create([
            'name' => 'Owner Admin',
            'email' => 'Owner@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'phone' => '081234567890',
            'address' => 'Jl. Admin Sejahtera No. 1', 
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'Admin@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
            'phone' => '081234567890',
            'address' => 'Jl. Admin Sejahtera No. 1', 
        ]);

        User::create([
            'name' => 'User',
            'email' => 'User@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 3,
            'phone' => '081234567890',
            'address' => 'Jl. Admin Sejahtera No. 1', 
        ]);
    }
}