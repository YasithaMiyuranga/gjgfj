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
        Schema::table('rent_items', function (Blueprint $table) {
            $table->foreign(['rent_id'], 'rent_items_ibfk_1')->references(['rent_id'])->on('rent')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rent_items', function (Blueprint $table) {
            $table->dropForeign('rent_items_ibfk_1');
        });
    }
};
