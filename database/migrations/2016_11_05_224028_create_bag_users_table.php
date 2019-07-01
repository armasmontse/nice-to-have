<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBagUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bag_user', function (Blueprint $table) {
            $table->primary('bag_id');

            $table->integer('bag_id')->unsigned()->unique();
            $table->integer('user_id')->unsigned()->nullable();

            $table->boolean('accept_terms')->default(false);

            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->text('info')->nullable();

            $table  ->foreign('bag_id')
                    ->references('id')
                    ->on('bags')
                    ->onDelete('RESTRICT');

            $table  ->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('RESTRICT');

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
        Schema::dropIfExists('bag_user');
    }
}
