<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRCmsUserLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_r_cms_user_log', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->string('module')->index();
            $table->text('action')->nullable();
            $table->text('message')->nullable();
            $table->integer('visibility')->default(0);
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
        Schema::dropIfExists('tbl_r_cms_user_log');
    }
}
