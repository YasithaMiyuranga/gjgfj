<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_book', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('customer_phone', 15)->nullable();
            $table->string('location', 100)->nullable();
            $table->string('event_name', 100)->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->date('booking_date')->nullable();
            $table->integer('order_id')->index('order_id');
            $table->string('item_name', 100)->nullable();
            $table->string('customer_name')->nullable();
            $table->string('name')->nullable();
            $table->string('order_status')->nullable();
            $table->boolean('is_pay')->nullable();
            $table->decimal('pay_amount', 10)->nullable();
            $table->decimal('payment_amount', 10)->nullable();
            $table->decimal('total_balance', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_book');
    }
};
