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
        Schema::create('rent_item_package_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('rent_item_package_id');
            $table->integer('item_id');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('rent_item_package_id')->references('id')->on('rent_item_packages')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('item_id')->references('item_id')->on('item')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_item_package_items');
    }
};
