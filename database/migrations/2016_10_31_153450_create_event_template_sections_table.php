<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTemplateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_template_sections', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('event_template_id')->unsigned();
            $table->integer('event_template_section_type_id')->unsigned();

            $table->unsignedInteger('order')->nullable();
            $table->boolean('publish')->default(false);
            $table->string('background_color',6)->default("ffffff");

            $table->string('title')->nullable()->default("");
            $table->text('link')->nullable();
            $table->text('html')->nullable();
            $table->text('iframe')->nullable();
            $table->text('content')->nullable();

            $table  ->foreign('event_template_id')
                    ->references('event_id')
                    ->on('event_templates')
                    ->onDelete('RESTRICT');

            $table  ->foreign('event_template_section_type_id')
                    ->references('id')
                    ->on('event_template_section_types')
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
        Schema::dropIfExists('event_template_sections');
    }
}
