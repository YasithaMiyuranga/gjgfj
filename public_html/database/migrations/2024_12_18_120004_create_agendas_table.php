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
        Schema::create('agendas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('event_id');
            $table->date('date');
            $table->string('date_name');
            $table->enum('is_active', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->foreign('event_id')->references('eid')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
