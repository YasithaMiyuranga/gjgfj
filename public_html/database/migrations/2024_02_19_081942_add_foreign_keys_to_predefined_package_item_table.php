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
        Schema::table('predefined_package_item', function (Blueprint $table) {
            $table->foreign(['predefined_package_id'], 'predefined_package_item_ibfk_1')->references(['package_id'])->on('predefined_package')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('predefined_package_item', function (Blueprint $table) {
            $table->dropForeign('predefined_package_item_ibfk_1');
        });
    }
};
