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
        Schema::create('customer_packages', function (Blueprint $table) {
            $table->integer('package_id', true);
            $table->string('customer_name');
            $table->string('mobile_no', 100);
            $table->string('location');
            $table->string('category', 150);
            $table->dateTime('starttime');
            $table->dateTime('endtime');
            $table->decimal('price', 10);
            $table->string('detail')->nullable();
            $table->string('status', 50);
            $table->string('type', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_packages');
    }
};
