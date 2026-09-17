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
        Schema::table('order', function (Blueprint $table) {            
            $table->integer('event_id')->nullable()->after('order_id');

            // Add foreign key constraint
             $table->foreign('event_id')
                   ->references('eid')
                   ->on('events')
                   ->onDelete('cascade')
                   ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order', function (Blueprint $table) {
             // Drop the foreign key constraint
             $table->dropForeign(['event_id']);

             // Drop the column if necessary
             $table->dropColumn('event_id');
        });
    }
};
