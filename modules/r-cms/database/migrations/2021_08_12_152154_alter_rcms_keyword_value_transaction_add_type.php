<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRcmsKeywordValueTransactionAddType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_r_cms_keyword_value_transaction', function (Blueprint $table) {
            //
            $table->integer('content_value')->default('0');
            $table->renameColumn('value','keyword_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_r_cms_keyword_value_transaction', function (Blueprint $table) {
            //
        });
    }
}
