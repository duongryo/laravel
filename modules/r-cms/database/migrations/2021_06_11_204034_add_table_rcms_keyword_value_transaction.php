<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableRcmsKeywordValueTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_r_cms_keyword_value_transaction', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('manager_id');
            $table->integer('value')->default(0);
            $table->integer('price')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('amount')->default(0);
            $table->string('method')->nullable();
            $table->string('invoice_id')->unique()->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('tbl_rcms_keyword_value_transaction');
    }
}
