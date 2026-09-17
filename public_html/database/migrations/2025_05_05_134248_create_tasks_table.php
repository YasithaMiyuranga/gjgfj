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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_template_id');
            $table->unsignedBigInteger('prev_task_id')->nullable();
            $table->unsignedBigInteger('next_task_id')->nullable();
            $table->string('task_name');
            $table->string('task_duration');
            $table->timestamps();

            $table->foreign('task_template_id')->references('id')->on('task_templates')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign('tasks_task_template_id_foreign');
        });

        Schema::dropIfExists('tasks');
    }
};
