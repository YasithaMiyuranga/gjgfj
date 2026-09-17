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
        Schema::create('predefined_package_item', function (Blueprint $table) {
            $table->integer('predefined_item_id', true);
            $table->integer('predefined_package_id')->index('predefined_package_id');
            $table->integer('item_id');
            $table->string('item_name')->nullable();
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('predefined_package_item');
    }
};
