<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('index')->unique();
            $table->string('template_path');
            $table->text('description');

            $table->integer('type_id')->unsigned();
            $table->integer('components_max')->unsigned()->nullable();
            $table->text('editable_contents');

            $table  ->foreign('type_id')
                    ->references('id')
                    ->on('sectiontypes')
                    ->onDelete('RESTRICT');

            $table->timestamps();
        });

        Schema::create('page_section', function (Blueprint $table) {
            $table->integer('page_id')->unsigned();
            $table->integer('section_id')->unsigned();

            $table->unsignedInteger('order')->nullable();

            $table->unique(['order', 'page_id']);
            $table->primary(['page_id', 'section_id']);

            $table  ->foreign('page_id')
                    ->references('id')
                    ->on('pages')
                    ->onDelete('RESTRICT');

            $table  ->foreign('section_id')
                    ->references('id')
                    ->on('sections')
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
        Schema::dropIfExists('page_section');
        Schema::dropIfExists('sections');
    }
}
