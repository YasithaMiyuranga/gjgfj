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
           
            $table->string('emp_type', 50)->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emp_payments', function (Blueprint $table) {
           
            $table->string('emp_type', 15)->change();
            
        });
    }
};
