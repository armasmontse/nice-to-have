<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename')->unique();
            $table->string('type');
            $table->timestamps();
        });

        Schema::create('language_photo', function (Blueprint $table) {
            $table->integer('language_id')->unsigned();
            $table->integer('photo_id')->unsigned();

            $table->string('title')->default("");
            $table->string('alt')->default("");
            $table->text('description')->nullable();

            $table->primary(['language_id','photo_id']);

            $table  ->foreign('language_id')
                    ->references('id')
                    ->on('languages')
                    ->onDelete('RESTRICT');

            $table  ->foreign('photo_id')
                    ->references('id')
                    ->on('photos')
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
        Schema::dropIfExists('language_photo');
        Schema::dropIfExists('photos');
    }
}
