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
        Schema::create('ticket_owners', function (Blueprint $table) {
            $table->integer('oid',true);
            $table->integer('event_id');
            $table->unsignedBigInteger('user_id');
            $table->string('email')->unique();
            $table->string('name');
            $table->string('nic');
            $table->text('phone_number');
            $table->text('address');
            $table->string('city');
            $table->string('zipcode');
            $table->double('total');
            $table->timestamps();

            $table->foreign('event_id')->references('eid')->on('events')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_owners');
    }
};
