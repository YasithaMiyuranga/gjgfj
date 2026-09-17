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
        Schema::create('additional_expenses', function (Blueprint $table) {
            $table->id();
            $table->Integer('order_id'); 
            $table->string('expense_name'); 
            $table->decimal('amount', 10, 2); 
            $table->text('description')->nullable(); 
            $table->date('expense_date'); 
            $table->timestamps();

            $table->foreign('order_id')->references('order_id')->on('order')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_expenses');
    }
};

