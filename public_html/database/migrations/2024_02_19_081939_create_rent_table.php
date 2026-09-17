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
        Schema::create('rent', function (Blueprint $table) {
            $table->integer('rent_id', true);
            $table->integer('employee_id');
            $table->integer('customer_id');
            $table->string('rent_status', 20)->default('Sent');
            $table->string('received_status', 20)->nullable();
            $table->string('note')->nullable();
            $table->string('employee_name', 100)->nullable();
            $table->string('customer_name', 100)->nullable();
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
        Schema::dropIfExists('rent');
    }
};
