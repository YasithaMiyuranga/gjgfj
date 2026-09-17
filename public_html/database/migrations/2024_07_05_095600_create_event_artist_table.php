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
        Schema::create('event_artist', function (Blueprint $table) {
            $table->id();
            $table->Integer('event_id');
            $table->Integer('artist_id');
            $table->timestamps();

            $table->foreign('event_id')->references('eid')->on('events')->onDelete('cascade');
            $table->foreign('artist_id')->references('aid')->on('artist')->onDelete('cascade');        
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_artist');
    }
};
