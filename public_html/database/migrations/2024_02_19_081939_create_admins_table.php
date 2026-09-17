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
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('profile_image')->nullable();
            $table->string('type')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('mobile')->nullable();
            $table->string('register_type')->default('email');
            $table->string('theme_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('current_store')->nullable();
            $table->string('lang')->nullable();
            $table->integer('plan')->default(1);
            $table->date('plan_expire_date')->nullable();
            $table->integer('plan_is_active')->default(1);
            $table->integer('requested_plan')->default(1);
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
        Schema::dropIfExists('admins');
    }
};
