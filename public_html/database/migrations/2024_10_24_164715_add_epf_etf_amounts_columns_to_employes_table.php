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
        Schema::table('employes', function (Blueprint $table) {
            $table->double('employer_con_etf_amount',)->nullable()->after('etf');
            $table->double('employer_con_epf_amount')->nullable()->after('epf');
            $table->double('employee_epf',)->nullable()->after('employer_con_epf_amount');
            $table->double('employee_con_epf_amount')->nullable()->after('employee_epf');
            $table->double('employer_con_total_amount')->nullable()->after('employee_con_epf_amount');
            $table->double('net_salary')->nullable()->after('employer_con_total_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employes', function (Blueprint $table) {
            $table->dropColumn('employer_con_etf_amount');
            $table->dropColumn('employer_con_epf_amount');
            $table->dropColumn('employee_epf');
            $table->dropColumn('employee_con_epf_amount');
            $table->dropColumn('employer_con_total_amount');
            $table->dropColumn('net_salary');
        });
    }
};
