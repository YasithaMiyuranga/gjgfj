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
        Schema::create('damage_items', function (Blueprint $table) {
            $table->id();
            $table->integer('rent_id');
            $table->integer('rent_item_id');
            $table->integer('quantity');
            $table->string('damage');
            $table->string('status');
            $table->timestamps();

            $table->foreign('rent_id')->references('rent_id')->on('rent')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('rent_item_id')->references('rent_item_id')->on('rent_items')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damage_items');
    }
};
