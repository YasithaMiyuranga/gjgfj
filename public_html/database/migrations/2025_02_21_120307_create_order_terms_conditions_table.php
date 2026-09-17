<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('order_terms_conditions', function (Blueprint $table) {
            $table->id();
            $table->Integer('order_id');
            $table->Integer('terms_and_conditions_id');
            $table->text('terms_description')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('order_id')->references('order_id')->on('order')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_terms_conditions');
    }
};
