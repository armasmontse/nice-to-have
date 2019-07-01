<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('index')->unique();

            $table->smallInteger('order')->unsigned()->nullable();

            $table->integer('parent_id')->unsigned()->nullable();
            $table->boolean('main')->default(false);
            $table->integer('publish_id')->unsigned()->nullable();
            $table->timestamp('publish_at')->nullable();

            $table->boolean('tblank')->default(0);

            // $table->boolean('header')->default(0);
            // $table->boolean('footer')->default(0);

            $table->timestamps();

            $table  ->foreign('publish_id')
                    ->references('id')
                    ->on('publishes')
                    ->onDelete('RESTRICT');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table  ->foreign('parent_id')
                    ->references('id')
                    ->on('pages');
        });

        Schema::create('language_page', function (Blueprint $table) {

            $table->integer('language_id')->unsigned();
            $table->integer('page_id')->unsigned();

            $table->string('label')->default("");
            $table->string('slug')->unique();

            $table->primary(['language_id','page_id']);

            $table  ->foreign('language_id')
                    ->references('id')
                    ->on('languages')
                    ->onDelete('RESTRICT');

            $table  ->foreign('page_id')
                    ->references('id')
                    ->on('pages')
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
        Schema::dropIfExists('language_page');
        Schema::dropIfExists('pages');
    }
}
