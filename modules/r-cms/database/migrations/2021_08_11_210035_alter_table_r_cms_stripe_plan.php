<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRCmsStripePlan extends Migration
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
            $table->integer('content_value')->default(0);
            $table->integer('keyword_value')->default(0);
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
