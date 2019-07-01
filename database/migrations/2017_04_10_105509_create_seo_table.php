<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('route_name');
            // $table->text('parameters');
            $table->integer('seoable_id')->nullable();
            $table->string('seoable_type')->nullable();

            $table->unique(['route_name', 'seoable_id', 'seoable_type']);

            $table->timestamps();
        });

        Schema::create('language_seo', function (Blueprint $table) {
            $table->integer('language_id')->unsigned();
            $table->integer('seo_id')->unsigned();

            $table->string('title')->nullable();
            $table->text('description')->nullable();

            $table->primary(['language_id', 'seo_id']);

            $table  ->foreign('language_id')
                    ->references('id')
                    ->on('languages')
                    ->onDelete('RESTRICT');

            $table  ->foreign('seo_id')
                    ->references('id')
                    ->on('seo')
                    ->onDelete('RESTRICT');

            $table->timestamps();
        });

        Schema::create('photo_seo', function (Blueprint $table) {
            $table->integer('photo_id')->unsigned();
            $table->integer('seo_id')->unsigned();

            $table->string('use')->default('thumbnail');
            $table->unsignedInteger('order')->nullable();
            $table->string('class')->nullable();

            $table->unique(['use', 'order', 'seo_id']);
            $table->unique(['photo_id', 'use', 'seo_id']);

            $table  ->foreign('photo_id')
                    ->references('id')
                    ->on('photos')
                    ->onDelete('RESTRICT');
            $table  ->foreign('seo_id')
                    ->references('id')
                    ->on('seo')
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
        Schema::dropIfExists('photo_seo');
        Schema::dropIfExists('language_seo');
        Schema::dropIfExists('seo');
    }
}
