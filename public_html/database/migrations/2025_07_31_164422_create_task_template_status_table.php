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
        Schema::create('task_template_status', function (Blueprint $table) {
            $table->unsignedBigInteger('task_template_id');
            $table->unsignedBigInteger('status_id');

            $table->foreign('task_template_id')->references('id')->on('task_templates')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');

            $table->primary(['task_template_id', 'status_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_template_status');
    }
};
