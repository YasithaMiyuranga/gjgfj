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
        Schema::create('event_coupon_lists', function (Blueprint $table) {
            $table->integer('id',true);
            $table->integer('event_id');
            $table->string('name');
            $table->bigInteger('coupon_no');
            $table->dateTime('event_date');
            $table->timestamps();

            $table->foreign('event_id')->references('eid')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_coupon_lists');
    }
};
