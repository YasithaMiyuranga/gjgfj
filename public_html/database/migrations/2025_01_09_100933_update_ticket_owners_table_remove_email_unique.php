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
        Schema::table('ticket_owners', function (Blueprint $table) {
            $table->dropUnique('ticket_owners_email_unique'); // Removes the unique constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_owners', function (Blueprint $table) {
            $table->string('email')->unique()->change(); // Restores the unique constraint
        });
    }
};
