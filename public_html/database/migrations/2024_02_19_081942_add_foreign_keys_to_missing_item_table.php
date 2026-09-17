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
        Schema::table('missing_item', function (Blueprint $table) {
            $table->foreign(['rent_item_id'], 'missing_item_ibfk_1')->references(['rent_item_id'])->on('rent_items')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('missing_item', function (Blueprint $table) {
            $table->dropForeign('missing_item_ibfk_1');
        });
    }
};
