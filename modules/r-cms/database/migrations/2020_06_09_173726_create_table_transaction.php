<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_r_cms_transaction', function (Blueprint $table) {
            $table->id();
            $table->integer('activation_id');
            $table->integer('user_id');
            $table->integer('manager_id');
            $table->integer('price')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('amount')->default(0);
            $table->string('coupon')->nullable();
            $table->string('type')->default('upgrade');
            $table->integer('from_plan');
            $table->integer('to_plan');
            $table->integer('plan_time')->default(30);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('tbl_r_cms_transaction');
    }
}
