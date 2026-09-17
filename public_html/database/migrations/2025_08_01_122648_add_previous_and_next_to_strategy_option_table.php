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
        Schema::table('strategy_option', function (Blueprint $table) {
            $table->integer('previous')->nullable()->after('option_id');
            $table->integer('next')->nullable()->after('previous');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('strategy_option', function (Blueprint $table) {
            $table->dropColumn(['previous', 'next']);
        });
    }
};
