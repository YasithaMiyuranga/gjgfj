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
        Schema::create('sponsors', function (Blueprint $table) {
            $table->integer('sponsor_id', true);
            $table->string('sponsor_name');
            $table->string('sponsor_phone', 15)->nullable();
            $table->string('sponsor_logo')->nullable();
            $table->string('sponsor_link')->nullable();
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
};
