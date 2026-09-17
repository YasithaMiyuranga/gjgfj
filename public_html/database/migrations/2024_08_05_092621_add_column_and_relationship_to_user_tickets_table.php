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
        Schema::table('user_tickets', function (Blueprint $table) {
             // Add the new column
             $table->unsignedBigInteger('ticket_order_list_id')->after('event_id');
             $table->string('qr_code')->nullable()->change();

             // Establish the relationship
             $table->foreign('ticket_order_list_id')
                 ->references('id')
                 ->on('ticket_order_lists')
                 ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_tickets', function (Blueprint $table) {
             // Drop the foreign key constraint
             $table->dropForeign(['ticket_order_list_id']);

             // Drop the column
             $table->dropColumn('ticket_order_list_id');
             $table->string('qr_code')->nullable(false)->change();
        });
    }
};
