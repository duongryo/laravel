<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblRTechPostCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_r_tech_post_category', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('slug', 255)->nullable()->unique();
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
        Schema::dropIfExists('tbl_r_tech_post_category');
    }
}
