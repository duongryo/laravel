<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableActivationChangePlanToPlanid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_r_cms_activation', function (Blueprint $table) {
            //
            $table->renameColumn('plan', 'plan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_r_cms_activation', function (Blueprint $table) {
            //
            $table->renameColumn('plan_id', 'plan');
        });
    }
}
