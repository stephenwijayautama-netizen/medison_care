<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel categories
            $table->foreignId('category_id')
                  ->constrained()
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Relasi ke tabel users (pembuat produk)
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->string('product_name');
            $table->text('description')->nullable(); // Saya buat nullable agar tidak error jika kosong
            // Menggunakan decimal agar support koma (jika perlu), atau ubah ke integer untuk Rupiah murni
            $table->decimal('price', 15, 2); 
            // --- TAMBAHAN UNTUK FITUR FRONTEND ---
            $table->decimal('promo_price', 15, 2)->nullable(); // Harga coret (boleh kosong)
            $table->boolean('promo')->default(false);          
            $table->boolean('best_seller')->default(false);
            // -------------------------------------
            $table->string('image')->nullable();
            $table->integer('stock')->default(0); // Menggunakan integer & default 0 biar aman
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};