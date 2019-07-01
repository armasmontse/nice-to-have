<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->unsignedInteger('order')->nullable();

            $table->unique(['category_id','order']);

            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('RESTRICT');
        });

        Schema::create('language_subcategory', function (Blueprint $table) {

            $table->integer('language_id')->unsigned();
            $table->integer('subcategory_id')->unsigned();

            $table->string('label')->default("");
            $table->string('slug')->unique()->nullable();

            $table->primary(['language_id','subcategory_id']);

            $table  ->foreign('language_id')
                    ->references('id')
                    ->on('languages')
                    ->onDelete('RESTRICT');

            $table  ->foreign('subcategory_id')
                    ->references('id')
                    ->on('subcategories')
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
        Schema::dropIfExists('language_subcategory');
        Schema::dropIfExists('subcategories');
    }
}
