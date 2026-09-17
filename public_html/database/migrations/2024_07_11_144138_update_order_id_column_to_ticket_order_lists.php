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

            $table->renameColumn('order_id', 'owner_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_order_lists', function (Blueprint $table) {
            
            $table->renameColumn('owner_id', 'order_id');
        });
    }
};
