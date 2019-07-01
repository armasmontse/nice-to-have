<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubtypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtypes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->unsigned();
            $table->unsignedInteger('order')->nullable();
            $table->timestamps();

            $table->unique(['type_id','order']);

            $table->foreign('type_id')
                ->references('id')
                ->on('types')
                ->onDelete('RESTRICT');
        });

        Schema::create('language_subtype', function (Blueprint $table) {

            $table->integer('language_id')->unsigned();
            $table->integer('subtype_id')->unsigned();

            $table->string('label')->default("");
            $table->string('slug')->unique()->nullable();

            $table->primary(['language_id','subtype_id']);

            $table  ->foreign('language_id')
                    ->references('id')
                    ->on('languages')
                    ->onDelete('RESTRICT');

            $table  ->foreign('subtype_id')
                    ->references('id')
                    ->on('subtypes')
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
        Schema::dropIfExists('language_subtype');
        Schema::dropIfExists('subtypes');
    }
}
