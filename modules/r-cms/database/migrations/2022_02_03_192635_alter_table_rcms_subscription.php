<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRcmsSubscription extends Migration
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
            $table->integer('status')->default(0)->change();
            $table->date('current_period_start')->nullable();
            $table->date('current_period_end')->nullable();
            $table->date('billing_cycle_anchor')->nullable();
            $table->string('interval')->nullable();
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
