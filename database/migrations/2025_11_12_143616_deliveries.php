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
        Schema::create('deliveries', function (Blueprint $table) { 
        $table->increments('id');
        $table->unsignedInteger('transaction_id');
        $table->unsignedInteger('courier_id');
        $table->string('tracking_numbers');
        $table->text('delivery_addres');
        $table->enum('status', ['preparing','shipped.in_transit','delivered','failed']);
        $table->text('notes')->nullable();
        $table->timestamp('shipped_at')->nullable();
        $table->timestamp('delivery_at')->nullable();
        
        $table->timestamps();
        $table->foreign('transaction_id')->references('id')->on('transactions')->onUpdate('cascade')->onDelete('cascade');
        $table->foreign('courier_id')->references('id')->on('couriers')->onUpdate('cascade')->ondelete('cascade');
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
