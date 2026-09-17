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
        Schema::create('item', function (Blueprint $table) {
            $table->integer('item_id', true);
            $table->string('item_name')->nullable();
            $table->integer('total_stock');
            $table->integer('in_stock');
            $table->integer('out_stock');
            $table->decimal('rent_price', 10)->nullable();
            $table->decimal('product_amount', 10)->nullable();
            $table->string('category')->nullable();
            $table->string('status')->nullable();
            $table->string('description')->nullable();
            $table->string('visible_to_customer', 12)->default('No');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('item');
    }
};
