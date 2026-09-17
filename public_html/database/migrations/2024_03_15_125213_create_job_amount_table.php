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
        Schema::create('job_amount', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('emp_id');
            $table->string('name', 255);
            $table->integer('order_id');
            $table->date('booking_date');
            $table->double('job_amount');
            $table->string('payment_status', 15);
            $table->date('payment_date');
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
        Schema::dropIfExists('job_amount');
    }
};
