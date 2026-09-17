<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageMetasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('image_metas', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key for this table
            $table->integer('album_image_id')->unique(); // Foreign key
            $table->string('image_name')->nullable();
            $table->string('image_alt')->nullable();
            $table->timestamps(); // created_at, updated_at

            $table->foreign('album_image_id')
                  ->references('aid')
                  ->on('album_images')
                  ->onDelete('cascade'); // Delete image meta when the image is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_metas');
    }
};
