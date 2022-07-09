<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblRTechPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_r_tech_post', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('category_id')->nullable();
            $table->string('images', 255)->nullable();
            $table->string('slug', 255)->nullable()->unique();
            $table->string('name', 255);
            $table->text('content');
            $table->text('meta_desc')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->text('tag')->nullable();
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
        Schema::dropIfExists('tbl_r_tech_post');
    }
}
