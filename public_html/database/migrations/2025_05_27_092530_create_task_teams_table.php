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
        Schema::create('task_teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('team_category_id');
            $table->unsignedBigInteger('team_member_id');
            $table->string('member_name');
            $table->string('role');
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('team_category_id')->references('id')->on('team_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('team_member_id')->references('id')->on('teams')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the foreign key constraints
        Schema::table('task_teams', function (Blueprint $table) {
            $table->dropForeign(['task_id']);
            $table->dropForeign(['team_category_id']);
            $table->dropForeign(['team_member_id']);
        });

        Schema::dropIfExists('task_teams');
    }
};
