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
       // Dropping the incorrect foreign key constraint
    Schema::table('customer_package_item', function (Blueprint $table) {
        $table->dropForeign('customer_package_item_ibfk_2');
    });

    // Adding the correct foreign key constraint
    Schema::table('customer_package_item', function (Blueprint $table) {
        $table->foreign(['package_id'], 'customer_package_item_ibfk_2')
              ->references(['package_id'])
              ->on('customer_packages')
              ->onUpdate('CASCADE')
              ->onDelete('CASCADE');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Dropping the correct foreign key constraint
    Schema::table('customer_package_item', function (Blueprint $table) {
        $table->dropForeign('customer_package_item_ibfk_2');
    });

    // Adding the old (incorrect) foreign key constraint back
    Schema::table('customer_package_item', function (Blueprint $table) {
        $table->foreign(['package_id'], 'customer_package_item_ibfk_2')
              ->references(['package_id'])
              ->on('package')
              ->onUpdate('CASCADE')
              ->onDelete('CASCADE');
    });
    }
};
