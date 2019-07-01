<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug',50)->unique();
            $table->string('label')->nullable();
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug',50)->unique();
            $table->string('label')->nullable();
            $table->timestamps();
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->primary(['permission_id','role_id']);

            $table  ->foreign('permission_id')
                    ->references('id')
                    ->on('permissions')
                    ->onDelete('RESTRICT');

            $table  ->foreign('role_id')
                    ->references('id')
                    ->on('roles')
                    ->onDelete('RESTRICT');

        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->primary(['user_id','role_id']);

            $table  ->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('RESTRICT');

            $table  ->foreign('role_id')
                    ->references('id')
                    ->on('roles')
                    ->onDelete('RESTRICT');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('role_user');

        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
    }
}
