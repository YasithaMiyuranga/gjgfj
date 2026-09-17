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
        Schema::table('monthly salary', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign('emp_id');

            // Recreate the foreign key with cascade on update and delete
            $table->foreign('emp_id')
                ->references('emp_id')
                ->on('employes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monthly salary', function (Blueprint $table) {
            // Drop the cascade foreign key
            $table->dropForeign('emp_id');

            // Recreate the original foreign key without cascade
            $table->foreign('emp_id')
                ->references('emp_id')
                ->on('employes');
        });
    }

};
