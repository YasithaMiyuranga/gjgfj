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
        Schema::create('user_tickets', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedBigInteger('ticket_id');
            $table->integer('event_id');
            $table->text('event_name');
            $table->unsignedBigInteger('user_id');
            $table->string('user_name');
            $table->text('user_phone_number');
            $table->string('qr_code');
            $table->dateTime('buy_date');
            $table->string('ticket_status');
            $table->timestamps();


            $table->foreign('event_id')->references('eid')->on('events')->onDelete('cascade');
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tickets');
    }
};
