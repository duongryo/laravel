<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRcmsTransactionAddInvoiceId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_r_cms_transaction', function (Blueprint $table) {
            //
            $table->string('invoice_id')->unique()->nullable();
            $table->string('subscription_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_r_cms_transaction', function (Blueprint $table) {
            //
            $table->dropColumn(['invoice_id', 'subscription_id']);
        });
    }
}
