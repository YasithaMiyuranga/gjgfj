<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('supplier_id');
            $table->decimal('total_price', 10)->nullable();
            $table->string('invoice_number', 100);
            $table->string('pay_type', 10)->nullable();
            $table->decimal('payment_amount', 10)->nullable();
            $table->decimal('balance', 10)->nullable();
            $table->decimal('discount_percentage', 10)->nullable();
            $table->decimal('discount_amount', 10)->nullable();
            $table->decimal('grand_total', 10)->nullable();
            $table->date('purchase_date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order');
    }
};
