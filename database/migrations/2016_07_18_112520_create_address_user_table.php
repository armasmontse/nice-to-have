<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_user', function (Blueprint $table) {

            $table->integer('address_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->string('use')->default("main");
            
            $table->unique(['address_id','user_id']);

            $table  ->foreign('address_id')
                    ->references('id')
                    ->on('addresses')
                    ->onDelete('RESTRICT');

            $table  ->foreign('user_id')
                    ->references('id')
                    ->on('users')
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
        Schema::dropIfExists('address_user');
    }
}
