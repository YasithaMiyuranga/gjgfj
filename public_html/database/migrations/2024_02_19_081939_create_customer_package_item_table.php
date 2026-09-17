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
        Schema::create('customer_package_item', function (Blueprint $table) {
            $table->integer('package_item_id', true);
            $table->integer('package_id')->index('package_id');
            $table->text('image');
            $table->integer('item_id')->index('item_id');
            $table->string('item_name')->nullable();
            $table->integer('quantity');
            $table->double('price');
            $table->double('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_package_item');
    }
};
