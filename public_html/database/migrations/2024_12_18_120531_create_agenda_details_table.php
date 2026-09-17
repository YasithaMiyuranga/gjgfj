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
        Schema::create('agenda_details', function (Blueprint $table) {
            $table->id();
            $table->integer('agenda_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->time('time');
            $table->enum('is_active', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->foreign('agenda_id')->references('id')->on('agendas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda_details');
    }
};
