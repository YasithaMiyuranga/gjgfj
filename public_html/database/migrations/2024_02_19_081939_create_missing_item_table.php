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
        Schema::create('missing_item', function (Blueprint $table) {
            $table->integer('missing_id', true);
            $table->integer('item_id');
            $table->integer('quantity');
            $table->integer('rent_item_id')->index('rent_item_id');
            $table->integer('rent_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('missing_item');
    }
};
