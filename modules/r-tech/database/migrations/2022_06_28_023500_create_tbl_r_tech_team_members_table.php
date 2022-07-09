<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblRTechTeamMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_r_tech_team_members', function (Blueprint $table) {
            $table->id();
            $table->string('images', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->text('position')->nullable();
            $table->text('description')->nullable();
            $table->integer('display_order')->nullable();
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
        Schema::dropIfExists('tbl_r_tech_team_members');
    }
}
