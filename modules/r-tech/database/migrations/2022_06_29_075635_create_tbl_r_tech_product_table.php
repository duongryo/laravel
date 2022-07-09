<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblRTechProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_r_tech_product', function (Blueprint $table) {
            $table->id();
            $table->string('label', 255);
            $table->string('name', 255);
            $table->text('link', 255)->nullable();
            $table->text('logo', 255)->nullable();
            $table->text('images', 255)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('tbl_r_tech_product');
    }
}
