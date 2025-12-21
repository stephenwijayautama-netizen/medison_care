<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) { 
        $table->increments('id'); // primary key
        $table->unsignedInteger('roles'); // <-- perbaikan
        $table->unsignedInteger('user_id');
        $table->decimal('total_amount', 8, 2);
        $table->decimal('shipping_cost', 8, 2);
        $table->enum('status', ['pending','paid','processing','shipped','delivered','cancelled']);
        $table->enum('payment_method', ['credit_card','bank_transfer','e-wallet','cod']);
        $table->timestamp('transaction_date');
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
