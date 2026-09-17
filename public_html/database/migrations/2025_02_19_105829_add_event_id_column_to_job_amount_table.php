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
        Schema::table('job_amount', function (Blueprint $table) {
            $table->integer('event_id')->nullable()->after('name');

            // Add foreign key constraint
             $table->foreign('event_id')
                   ->references('eid')
                   ->on('events')
                   ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_amount', function (Blueprint $table) {
             // Drop the foreign key constraint
             $table->dropForeign(['event_id']);

             // Drop the column if necessary
             $table->dropColumn('event_id');
        });
    }
};
