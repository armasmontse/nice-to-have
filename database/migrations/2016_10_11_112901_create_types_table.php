<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order')->unique()->nullable();
            $table->timestamps();
        });

        Schema::create('language_type', function (Blueprint $table) {

            $table->integer('language_id')->unsigned();
            $table->integer('type_id')->unsigned();

            $table->string('label')->default("");
            $table->string('slug')->unique()->nullable();
            $table->string('title')->default("");
            $table->text('description')->nullable();

            $table->primary(['language_id','type_id']);

            $table  ->foreign('language_id')
                    ->references('id')
                    ->on('languages')
                    ->onDelete('RESTRICT');

            $table  ->foreign('type_id')
                    ->references('id')
                    ->on('types')
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
        Schema::dropIfExists('language_type');
        Schema::dropIfExists('types');
    }
}
