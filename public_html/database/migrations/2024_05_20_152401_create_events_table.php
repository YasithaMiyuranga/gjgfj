<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->integer('eid', true);
            $table->text('event_name');
            $table->text('des');
            $table->dateTime('event_date');
            $table->text('location');
            $table->text('type');
            $table->text('category');
            $table->text('event_manager');
            $table->text('contact_no');
            $table->text('logo');
            $table->text('banner');
            $table->text('status');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
