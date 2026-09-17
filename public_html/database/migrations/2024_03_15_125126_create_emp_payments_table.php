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
        Schema::create('emp_payments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('emp_id')->index('emp_id');
            $table->string('name');
            $table->double('pay_amount');
            $table->date('date');
            $table->string('emp_type', 15);
            $table->string('payment_status', 15);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emp_payments');
    }
};
