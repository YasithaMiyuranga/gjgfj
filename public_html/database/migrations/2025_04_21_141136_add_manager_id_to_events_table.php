<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('events', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->unsignedBigInteger('event_manager_id')->nullable();
            $table->foreign('event_manager_id')
                  ->references('manager_id')->on('managers')
                  ->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('events', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->dropForeign(['event_manager_id']);
            $table->dropColumn('event_manager_id');
        });
    }
    
    
};
