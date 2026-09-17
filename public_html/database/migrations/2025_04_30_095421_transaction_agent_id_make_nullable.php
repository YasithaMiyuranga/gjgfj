<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        Schema::table('transactions', function (Blueprint $table) {
            // Modify the column to be unsigned and nullable
            $table->integer('agent_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('agent_id')->nullable(false)->change();
        });
    }

};
