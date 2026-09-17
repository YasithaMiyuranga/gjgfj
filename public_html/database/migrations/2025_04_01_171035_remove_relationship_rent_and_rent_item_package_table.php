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
        Schema::table('rent', function (Blueprint $table) {
            $table->dropForeign(['rent_item_package_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rent', function (Blueprint $table) {
            $table->foreign('rent_item_package_id')->references('id')->on('rent_item_packages');
        });
    }
};
