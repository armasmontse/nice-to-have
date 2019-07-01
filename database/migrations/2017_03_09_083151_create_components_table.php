<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->increments('id');
            $table->string('index')->nullable();
            $table->integer('section_id')->unsigned();
            $table->unsignedInteger('order')->nullable();
            $table->unique(['order', 'section_id']);

            $table  ->foreign('section_id')
                    ->references('id')
                    ->on('sections')
                    ->onDelete('RESTRICT');

            $table->timestamps();
        });

        Schema::create('component_language', function (Blueprint $table) {
            $table->integer('language_id')->unsigned();
            $table->integer('component_id')->unsigned();

            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('excerpt')->nullable();

            $table->text('content')->nullable();
            $table->text('iframe')->nullable();

            $table->string('link_url')->nullable();
            $table->string('link_title')->nullable();
            $table->boolean('link_tblank')->nullable();

            $table->primary(['language_id', 'component_id']);

            $table  ->foreign('language_id')
                    ->references('id')
                    ->on('languages')
                    ->onDelete('RESTRICT');
            $table  ->foreign('component_id')
                    ->references('id')
                    ->on('components')
                    ->onDelete('RESTRICT');

            $table->timestamps();
        });

        Schema::create('component_photo', function (Blueprint $table) {
            $table->integer('photo_id')->unsigned();
            $table->integer('component_id')->unsigned();

            $table->string('use')->default('thumbnail');
            $table->unsignedInteger('order')->nullable();
            $table->string('class')->nullable();

            $table->unique(['use', 'order', 'component_id']);
            $table->unique(['photo_id', 'use', 'component_id']);

            $table  ->foreign('photo_id')
                    ->references('id')
                    ->on('photos')
                    ->onDelete('RESTRICT');
            $table  ->foreign('component_id')
                    ->references('id')
                    ->on('components')
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
        Schema::dropIfExists('component_photo');
        Schema::dropIfExists('component_language');
        Schema::dropIfExists('components');
    }
}
