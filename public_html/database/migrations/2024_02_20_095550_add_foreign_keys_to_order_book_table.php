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
        Schema::table('order_book', function (Blueprint $table) {
            $table->foreign(['order_id'], 'order_book_ibfk_1')->references(['order_id'])->on('order')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_book', function (Blueprint $table) {
            $table->dropForeign('order_book_ibfk_1');
        });
    }
};
