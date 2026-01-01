<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // ✅ BIGINT UNSIGNED

            // [BARU] Invoice Number untuk Doku (String, Unik)
            // Contoh: INV-20231201-0001
            $table->string('invoice_number')->unique()->nullable();

            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->decimal('total_amount', 10, 2);
            $table->decimal('shipping_cost', 10, 2);
            
            // [BARU] Menyimpan URL pembayaran dari Doku
            $table->text('payment_url')->nullable();

            $table->enum('status', [
                'pending',
                'paid',
                'processing',
                'shipped',
                'delivered',
                'cancelled',
                'expired', // Tambahan: status expired jika tidak dibayar
                'failed'   // Tambahan: status failed
            ])->default('pending');

            // [UBAH] Saya ubah jadi String & Nullable
            // Karena saat checkout, user mungkin belum pilih metode (pilihnya di halaman Doku)
            // Dan Doku mengembalikan kode seperti 'VIRTUAL_ACCOUNT_BCA' yang tidak sesuai enum awal Anda
            $table->string('payment_method')->nullable(); 

            // Jika Anda ingin tetap pakai enum, pastikan listnya mencakup kode dari Doku
            // $table->enum('payment_method', [...])->nullable();

            $table->timestamp('transaction_date')->useCurrent(); // Default current time
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};