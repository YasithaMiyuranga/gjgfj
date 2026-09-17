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
        Schema::create('customer', function (Blueprint $table) {
            $table->integer('customer_id', true);
            $table->string('customer_name')->nullable();
            $table->string('customer_phone', 15)->nullable();
            $table->string('location')->nullable();
            $table->string('nic')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->text('status')->nullable();
            $table->string('points')->nullable();
            $table->date('register_date')->nullable();
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
        Schema::dropIfExists('customer');
    }
};
