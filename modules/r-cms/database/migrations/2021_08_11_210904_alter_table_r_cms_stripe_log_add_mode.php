<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRCmsStripeLogAddMode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_r_cms_stripe_log', function (Blueprint $table) {
            //
            $table->string('mode')->default('subscription');
            $table->string('plan_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_r_cms_stripe_log', function (Blueprint $table) {
            //
        });
    }
}
