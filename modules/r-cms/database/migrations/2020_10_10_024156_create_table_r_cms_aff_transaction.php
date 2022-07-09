<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRCmsAffTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_r_cms_aff_transaction', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->integer('customer_id')->index();
            $table->string('action');
            $table->integer('transaction_id')->nullable();
            $table->bigInteger('credit');
            $table->string('note')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('tbl_r_cms_aff_transaction');
    }
}
