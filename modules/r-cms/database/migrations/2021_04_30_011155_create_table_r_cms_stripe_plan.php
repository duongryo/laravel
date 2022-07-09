<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRCmsStripePlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_r_cms_stripe_plan', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->integer('plan_id');
            $table->string('type')->default('monthly');
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
        Schema::dropIfExists('tbl_r_cms_stripe_plan');
    }
}
