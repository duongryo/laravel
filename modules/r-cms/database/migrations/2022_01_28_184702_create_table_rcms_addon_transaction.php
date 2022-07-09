<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRcmsAddonTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_r_cms_addon_transaction', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('addon');
            $table->float('price')->default(0);
            $table->integer('quantity')->default(1);
            $table->float('discount')->default(0);
            $table->float('amount')->default(0);
            $table->string('coupon')->nullable();
            $table->string('method');
            $table->string('invoice_id')->nullable();
            $table->string('subscription_id')->nullable();
            $table->string('note')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('tbl_r_cms_addon_transaction');
    }
}
