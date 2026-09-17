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
        Schema::table('employee_credits', function (Blueprint $table) {
            $table->enum('credit_status', ['pending', 'approved', 'rejected', 'paid'])->default('pending')->after('employee_id');
            $table->date('paid_date')->nullable()->after('credit_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_credits', function (Blueprint $table) {
            $table->dropColumn('credit_status');
            $table->dropColumn('paid_date');
        });
    }
};
