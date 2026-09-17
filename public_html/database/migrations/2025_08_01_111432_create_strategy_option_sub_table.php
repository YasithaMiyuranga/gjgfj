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
        Schema::create('strategy_option_sub', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_option_id');
            $table->unsignedBigInteger('strategy_option_id');
            $table->integer('previous')->nullable();
            $table->integer('next')->nullable();
            $table->timestamps();

            $table->foreign('sub_option_id')->references('id')->on('sub_options')->onDelete('cascade');
            $table->foreign('strategy_option_id')->references('id')->on('strategy_option')->onDelete('cascade');

            $table->unique(['sub_option_id', 'strategy_option_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strategy_option_sub');
    }
};
