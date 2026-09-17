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
        Schema::table('events', function (Blueprint $table) {
             // Add new columns
             $table->dateTime('start_datetime')->nullable()->after('event_date');
             $table->dateTime('end_datetime')->nullable()->after('start_datetime');

             // Change the data type of `event_date`
             $table->date('event_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Drop the new columns
            $table->dropColumn(['start_datetime', 'end_datetime']);

            // Revert the column type of `event_date`
            $table->dateTime('event_date')->change();
        });
    }
};
