<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTemplateSectionPhotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_template_section_photo', function (Blueprint $table) {
            $table->integer('photo_id')->unsigned();
            $table->integer('event_template_section_id')->unsigned();

            $table->string('use')->default("thumbnail");
            $table->unsignedInteger('order')->nullable();
            $table->string('class')->nullable();

            $table->unique(['use', 'order' ,'event_template_section_id'], 'template_section_photo_use_order_template_section_id_unique' );

            $table->unique(['photo_id', 'use' ,'event_template_section_id'] , 'template_section_photo_photo_id_order_template_section_id_unique' );

            $table  ->foreign('photo_id')
                    ->references('id')
                    ->on('photos')
                    ->onDelete('RESTRICT');

            $table  ->foreign('event_template_section_id')
                    ->references('id')
                    ->on('event_template_sections')
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
        Schema::dropIfExists('event_template_section_photo');
    }
}
