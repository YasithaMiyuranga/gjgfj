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
        Schema::create('rent_update_history', function (Blueprint $table) {
            $table->id();
            $table->integer('rent_id')->index();
            $table->integer('item_id')->nullable();
            $table->integer('employee_id')->nullable();
            $table->enum('action', ['add', 'remove', 'update'])->nullable();
            $table->integer('previous_quantity')->nullable();
            $table->integer('current_quantity')->nullable();
            $table->integer('updated_quantity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_update_history');
    }
};
