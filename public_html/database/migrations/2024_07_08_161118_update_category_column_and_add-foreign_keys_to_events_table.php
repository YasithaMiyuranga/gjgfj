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
        // First, rename the column
        Schema::table('events', function (Blueprint $table) {
            $table->renameColumn('category', 'category_id');
        });

        // Then, change the type and add the foreign key constraint
        Schema::table('events', function (Blueprint $table) {
            $table->integer('category_id')->change();
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            
          // First, drop the foreign key constraint
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        // Then, change the type back to text
        Schema::table('events', function (Blueprint $table) {
            $table->text('category_id')->change();
        });

        // Finally, rename the column back
        Schema::table('events', function (Blueprint $table) {
            $table->renameColumn('category_id', 'category');
        });
        });
    }
};
