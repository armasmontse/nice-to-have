<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_templates', function (Blueprint $table) {
            // $table->increments('id');
            $table->integer('event_id')->unsigned()->unique();
            $table->integer('event_template_header_id')->unsigned()->nullable();

            $table->primary('event_id');

            $table->boolean('publish')->default(false);
            $table->boolean('timer')->default(false);

            $table->string('background_color',6)->default("ffffff");
            $table->string('image_background_color',6)->default("000000");


            $table  ->foreign('event_id')
                    ->references('id')
                    ->on('events')
                    ->onDelete('RESTRICT');

            $table  ->foreign('event_template_header_id')
                    ->references('id')
                    ->on('event_template_headers')
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
        Schema::dropIfExists('event_templates');
    }
}
