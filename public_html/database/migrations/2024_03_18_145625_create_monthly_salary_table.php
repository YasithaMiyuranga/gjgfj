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
        Schema::create('monthly salary', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('emp_id')->index('emp_id');
            $table->string('name');
            $table->string('emp_type', 50);
            $table->double('basic_amount');
            $table->double('etf');
            $table->double('epf');
            $table->integer('job_amount');
            $table->double('loan_amount');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('salary_status', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly salary');
    }
};
