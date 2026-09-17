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
        Schema::create('event_customer_cares', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id');
            $table->string('email')->unique()->nullable();
            $table->text('address')->nullable();
            $table->text('whatsapp_number')->nullable();
            $table->timestamps();

            $table->foreign('event_id')->references('eid')->on('events')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('event_customer_cares', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropIfExists('event_customer_cares');
        });
    }
};
