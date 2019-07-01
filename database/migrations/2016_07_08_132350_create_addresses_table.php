<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id');
            $table->string('contact_name')->default("");
            $table->string('phone')->default("");
			$table->string('email')->default("")->nullable();
            $table->string('references')->default("")->nullable();
            $table->string('street1', 255)->default("");
            $table->string('street2', 255)->default("");
            $table->string('street3', 255)->default("");
            $table->string('city', 255)->default("");
            $table->string('state', 255)->default("");
            $table->string('zip')->default("");

            $table  ->foreign('country_id')
                    ->references('id')
                    ->on('countries')
                    ->onDelete('RESTRICT');

            $table->timestamps();
            $table->softDeletes();
        });

        //COPY FROM HERE TO HERE
            // Schema::create('address_user', function (Blueprint $table) {
            //
            //     $table->integer('address_id')->unsigned();
            //     $table->integer('user_id')->unsigned();
            //
            //     $table->string('use');
            //
            //     $table->unique(['address_id','user_id']);
            //
            //     $table  ->foreign('address_id')
            //             ->references('id')
            //             ->on('addresses')
            //             ->onDelete('RESTRICT');
            //
            //     $table  ->foreign('user_id')
            //             ->references('id')
            //             ->on('users')
            //             ->onDelete('RESTRICT');
            // });
        // TO HERE FOR MIGRATIONS THAT HAVE ADDRESSES
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('addresses');
    }
}
