<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order')->unique()->nullable();
            $table->timestamps();
        });

        Schema::create('category_language', function (Blueprint $table) {

            $table->integer('language_id')->unsigned();
            $table->integer('category_id')->unsigned();

            $table->string('label')->default("");
            $table->string('slug')->unique()->nullable();

            $table->primary(['language_id','category_id']);

            $table  ->foreign('language_id')
                    ->references('id')
                    ->on('languages')
                    ->onDelete('RESTRICT');

            $table  ->foreign('category_id')
                    ->references('id')
                    ->on('categories')
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
        Schema::dropIfExists('category_language');
        Schema::dropIfExists('categories');
    }
}
