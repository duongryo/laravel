<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRCmsUserAddPhone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->integer('role')->default(3);
            $table->string('phone')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birth')->nullable();
            $table->integer('gender')->default(0);
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->integer('plan')->default(1);

            if (!Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
