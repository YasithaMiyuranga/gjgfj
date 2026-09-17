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
            // Make existing columns nullable           
            $table->text('des')->nullable()->change();
            $table->dateTime('event_date')->nullable()->change();
            $table->text('location')->nullable()->change();
            $table->text('type')->nullable()->change();
            $table->integer('category_id')->nullable()->change();
            $table->text('event_manager')->nullable()->change();
            $table->text('contact_no')->nullable()->change();
            $table->text('logo')->nullable()->change();
            $table->text('banner')->nullable()->change();
            $table->text('status')->nullable()->change();  

            // Add the `is_public` column
            $table->boolean('is_public')->default(0)->comment('0 = not visible in website, 1 = visible in website')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Revert columns to non-nullable           
            $table->text('des')->nullable(false)->change();
            $table->dateTime('event_date')->nullable(false)->change();
            $table->text('location')->nullable(false)->change();
            $table->text('type')->nullable(false)->change();
            $table->integer('category_id')->nullable(false)->change();
            $table->text('event_manager')->nullable(false)->change();
            $table->text('contact_no')->nullable(false)->change();
            $table->text('logo')->nullable(false)->change();
            $table->text('banner')->nullable(false)->change();
            $table->text('status')->nullable(false)->change();

            // Remove the `is_public` column
            $table->dropColumn('is_public');
        });
    }
};
