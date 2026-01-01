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

        DB::table('products')->insert([
            [
                'category_id' => 1, // Susu Kecik Bubuk
                'created_by' => 1,
                'product_name' => 'Susu Bubuk Anak Vanila 400g',
                'description' => 'Susu bubuk bernutrisi tinggi untuk anak usia 1–5 tahun.',
                'price' => 75000.00,
                'promo_price' => 69000.00,
                'promo' => true,
                'best_seller' => true,
                'image' => 'products/susu-bubuk-vanila.jpg',
                'stock' => 120,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'created_by' => 1,
                'product_name' => 'Susu Bubuk Coklat 800g',
                'description' => 'Susu bubuk rasa coklat dengan kalsium tinggi.',
                'price' => 120000.00,
                'promo_price' => null,
                'promo' => false,
                'best_seller' => false,
                'image' => 'products/susu-bubuk-coklat.jpg',
                'stock' => 80,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2, // Susu Besar Cair
                'created_by' => 1,
                'product_name' => 'Susu Cair Full Cream 1L',
                'description' => 'Susu cair full cream kaya protein untuk keluarga.',
                'price' => 18000.00,
                'promo_price' => 16000.00,
                'promo' => true,
                'best_seller' => true,
                'image' => 'products/susu-cair-fullcream.jpg',
                'stock' => 200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'created_by' => 1,
                'product_name' => 'Susu Cair Low Fat 1L',
                'description' => 'Susu rendah lemak untuk gaya hidup sehat.',
                'price' => 20000.00,
                'promo_price' => null,
                'promo' => false,
                'best_seller' => false,
                'image' => 'products/susu-cair-lowfat.jpg',
                'stock' => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3, // Susu Ibu Hamil
                'created_by' => 1,
                'product_name' => 'Susu Ibu Hamil Rasa Stroberi',
                'description' => 'Susu khusus ibu hamil dengan asam folat dan zat besi.',
                'price' => 95000.00,
                'promo_price' => 89000.00,
                'promo' => true,
                'best_seller' => true,
                'image' => 'products/susu-ibu-hamil-stroberi.jpg',
                'stock' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}