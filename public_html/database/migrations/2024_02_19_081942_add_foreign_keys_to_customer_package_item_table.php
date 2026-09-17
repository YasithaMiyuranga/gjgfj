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
        Schema::table('customer_package_item', function (Blueprint $table) {
            $table->foreign(['package_id'], 'customer_package_item_ibfk_2')->references(['package_id'])->on('package')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['item_id'], 'customer_package_item_ibfk_1')->references(['item_id'])->on('item')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_package_item', function (Blueprint $table) {
            $table->dropForeign('customer_package_item_ibfk_2');
            $table->dropForeign('customer_package_item_ibfk_1');
        });
    }
};
