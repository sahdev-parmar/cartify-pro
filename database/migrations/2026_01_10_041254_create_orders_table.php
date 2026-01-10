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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', [
                'pending',
                'confirmed',
                'cancelled',
            ])->default('pending')->comment('enum(pending,confirmed,cancelled)');
            $table->enum('payment_method', [
                'cod',
                'upi',
                'bank_transfer'
            ])->default('cod')->comment('enum(cod,upi,bank_transfer)');
            $table->decimal('total', 10, 2); // Final total
            $table->text('address');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('country_id');
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
