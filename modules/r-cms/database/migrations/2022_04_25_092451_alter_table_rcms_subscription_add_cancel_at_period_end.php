<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRcmsSubscriptionAddCancelAtPeriodEnd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_r_cms_subscription', function (Blueprint $table) {
            //
            $table->integer('cancel_at_period_end')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_r_cms_subscription', function (Blueprint $table) {
            //
        });
    }
}
