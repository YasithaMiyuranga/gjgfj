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
        Schema::table('monthly salary', function (Blueprint $table) {
            $table->foreign(['emp_id'], 'emp_id')->references(['emp_id'])->on('employes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monthly salary', function (Blueprint $table) {
            $table->dropForeign('emp_id');
        });
    }
};
