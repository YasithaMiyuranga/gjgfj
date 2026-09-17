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
        Schema::create('rent_item_supplier', function (Blueprint $table) {
            $table->id();
            $table->integer('rent_item_id');
            $table->integer('supplier_id');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();

            $table->foreign('rent_item_id')->references('rent_item_id')->on('rent_items')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rent_item_supplier', function (Blueprint $table) {
            $table->dropForeign(['rent_item_id']);
            $table->dropForeign(['supplier_id']);
        });

        Schema::dropIfExists('rent_item_supplier');
    }
};
