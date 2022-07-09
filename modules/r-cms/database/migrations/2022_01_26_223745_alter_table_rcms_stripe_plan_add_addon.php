<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRcmsStripePlanAddAddon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_r_cms_stripe_plan', function (Blueprint $table) {
            //
            $table->string('addon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_r_cms_stripe_plan', function (Blueprint $table) {
            //
        });
    }
}
