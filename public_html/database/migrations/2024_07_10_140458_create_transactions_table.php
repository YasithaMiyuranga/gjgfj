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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('agent_id');
            $table->bigInteger('transaction_id');
            $table->double('amount');
            $table->text('buyer_phone_number');
            $table->string('nic');
            $table->timestamps();


            
            $table->foreign('event_id')->references('eid')->on('events')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');   
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
