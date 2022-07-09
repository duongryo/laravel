<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTblPlanAddStripeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_r_cms_plan', function (Blueprint $table) {
            //
            $table->string('stripe_monthly_id')->nullable();
            $table->string('stripe_anual_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_r_cms_plan', function (Blueprint $table) {
            //
        });
    }
}
