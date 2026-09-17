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
            $table->integer('event_id')->nullable(true)->after('employee_id');
            $table->integer('rent_item_package_id')->nullable(true)->after('event_id');

            $table->foreign('event_id')->references('eid')->on('events');
            $table->foreign('rent_item_package_id')->references('id')->on('rent_item_packages');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rent', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
            $table->dropForeign(['rent_item_package_id']);
            $table->dropColumn('rent_item_package_id');
        });
    }
};
