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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->nullable();
            $table->string('user_email', 100);
            $table->string('order_code', 100)->unique();
            $table->integer('total_amount');
            $table->string('midtrans_snap_token', 255)->nullable();
            $table->string('midtrans_transaction_id', 255)->nullable();
            $table->enum('status', ['pending', 'success', 'cancelled', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
