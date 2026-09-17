<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ticket_order_lists', function (Blueprint $table) {
            $table->dropForeign(['ticket_user_id']);
            $table->dropColumn('ticket_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_order_lists', function (Blueprint $table) {
            $table->integer('ticket_user_id');
            $table->foreign('ticket_user_id')->references('id')->on('user_tickets')->onDelete('cascade');
        });
    }
};
