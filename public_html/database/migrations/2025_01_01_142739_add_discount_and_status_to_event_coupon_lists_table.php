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
        Schema::table('event_coupon_lists', function (Blueprint $table) {
            $table->decimal('discount_percentage', 5, 2)->nullable()->after('coupon_no');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('discount_percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_coupon_lists', function (Blueprint $table) {
            $table->dropColumn(['discount_amount', 'discount_percentage', 'status']);
        });
    }
};
