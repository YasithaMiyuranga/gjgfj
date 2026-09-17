<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTermIdToAgreementSubTerms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agreement_sub_terms', function (Blueprint $table) {
            $table->unsignedBigInteger('agreement_term_id')->nullable()->after('agreement_id');
            $table->foreign('agreement_term_id')->references('id')->on('agreement_terms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agreement_sub_terms', function (Blueprint $table) {
            $table->dropForeign(['agreement_term_id']);
            $table->dropColumn('agreement_term_id');
        });
    }
}
