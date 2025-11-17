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
        Schema::create('transaction_details', function (Blueprint $table) { 
        $table->increments('id');
        $table->unsignedInteger('transaction_id');
        $table->unsignedInteger('product_id');
        $table->unsignedInteger('quantity');
        $table->string('product_name');
        $table->decimal('price');
        $table->decimal('subtotal');
        $table->timestamps();
        $table->foreign('transaction_id')->references('id')->on('transactions')->onUpdate('cascade')->onDelete('cascade');
        $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
        });  
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactiondetails');
    }
};
