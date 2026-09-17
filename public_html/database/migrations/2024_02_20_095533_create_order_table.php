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
        Schema::create('order', function (Blueprint $table) {
            $table->integer('order_id', true);
            $table->string('customer_name')->nullable();
            $table->string('location', 100)->nullable();
            $table->string('event_name', 100)->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->string('customer_phone', 15)->nullable();
            $table->string('name')->nullable();
            $table->string('order_type')->nullable();
            $table->date('booking_date')->nullable();
            $table->date('inv_date')->nullable();
            $table->string('order_status')->nullable();
            $table->string('category')->nullable();
            $table->decimal('net_amount', 10)->nullable();
            $table->decimal('additional_price', 10)->nullable();
            $table->double('total_discount', 8, 2)->nullable();
            $table->decimal('grand_total', 10)->nullable();
            $table->decimal('pay_amount', 10)->nullable();
            $table->decimal('final_amount', 10)->nullable();
            $table->decimal('tax', 10)->nullable();
            $table->decimal('transport', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
};
