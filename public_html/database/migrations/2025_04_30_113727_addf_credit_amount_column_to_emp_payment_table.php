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
        Schema::table('emp_payments', function (Blueprint $table) {
            $table->float('credit_amount')->default(0)->after('pay_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emp_payments', function (Blueprint $table) {
            $table->dropColumn('credit_amount');
        });
    }
};
