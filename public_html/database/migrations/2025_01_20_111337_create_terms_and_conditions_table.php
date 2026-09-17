<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('terms_and_conditions', function (Blueprint $table) {
        $table->id(); // Primary Key
        $table->integer('order_id');
        $table->string('title')->nullable(); // Title of the terms
        $table->text('description')->nullable(); // Detailed terms
        $table->boolean('is_active')->default(true); // Whether the terms are active
        $table->timestamps(); // Created_at and updated_at columns

        $table->foreign('order_id')->references('order_id')->on('order')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terms_and_conditions');
    }
};
