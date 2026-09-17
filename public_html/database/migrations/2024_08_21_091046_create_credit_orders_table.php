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
        Schema::create('credit_orders', function (Blueprint $table) {
            $table->bigIncrements('credit_order_id');
            $table->Integer('order_id');
            $table->Integer('customer_id');
            $table->string('customer_name')->nullable();
            $table->decimal('total_amount', 10)->nullable();
            $table->decimal('credit_amount', 10)->nullable();
            $table->date('booking_date')->nullable();
            $table->timestamps();

          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_orders');
    }
};
