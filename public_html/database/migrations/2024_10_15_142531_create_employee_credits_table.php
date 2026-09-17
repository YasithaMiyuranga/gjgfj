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
        Schema::create('employee_credits', function (Blueprint $table) {
            $table->integer('Employee_credit_id', true);
            $table->integer('employee_id');
            $table->double('credit_amount');
            $table->date('credit_date');
            $table->timestamps();

            $table->foreign('employee_id')->references('emp_id')->on('employes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_credits');
    }
};
