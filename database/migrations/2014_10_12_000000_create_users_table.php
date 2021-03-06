<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();

            $table->string('first_name');
            $table->string('last_name');

            $table->string('email')->unique();
			$table->string('phone')->nullable();
            $table->string('password', 60);
            $table->rememberToken();

            $table->boolean('active')->default(false);
            // $table->dateTime('last_login')->nullable();
            $table->string('facebook_id')->unique()->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
