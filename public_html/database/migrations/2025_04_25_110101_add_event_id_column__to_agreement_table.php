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
        Schema::table('agreements', function (Blueprint $table) {
            //emp_id nullable
            $table->integer('emp_id')->nullable(true)->change();
        });
        // Add event_id column to agreements table
        Schema::table('agreements', function (Blueprint $table) {
            $table->integer('event_id')->nullable(true)->after('emp_id');
            $table->foreign('event_id')->references('eid')->on('events')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove emp_id nullable
        Schema::table('agreements', function (Blueprint $table) {
            $table->integer('emp_id')->nullable(false)->change();
        });
        // Remove event_id column from agreements table
        Schema::table('agreements', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
        });
    }
};
