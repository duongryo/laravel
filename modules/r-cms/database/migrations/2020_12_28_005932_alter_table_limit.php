<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableLimit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_r_cms_limit', function (Blueprint $table) {
            //
            $table->dropColumn(['module','free','premium','platinum']);
            $table->integer('module_id');
            $table->integer('plan_id');
            $table->integer('limit')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_r_cms_limit', function (Blueprint $table) {
            //
        });
    }
}
