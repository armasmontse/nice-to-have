<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('iso3166', 2);

            $table->timestamps();
        });

        Schema::create('country_language', function (Blueprint $table) {
            $table->integer('language_id')->unsigned();
            $table->integer('country_id')->unsigned();

            $table->string('official_name',255);

            $table->primary(['language_id','country_id']);

            $table  ->foreign('language_id')
                    ->references('id')
                    ->on('languages')
                    ->onDelete('RESTRICT');

            $table  ->foreign('country_id')
                    ->references('id')
                    ->on('countries')
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
        Schema::drop('country_language');
        Schema::drop('countries');
    }
}
