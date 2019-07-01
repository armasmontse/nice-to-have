<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorPalettesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_palettes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('color_1',6)->default("ffffff");
            $table->string('color_2',6)->default("ffffff");
            $table->string('color_3',6)->default("ffffff");
            $table->timestamps();
        });

        Schema::table('event_templates', function (Blueprint $table) {
            $table->unsignedInteger('color_palette_id')->nullable();

            $table  ->foreign('color_palette_id')
                    ->references('id')
                    ->on('color_palettes')
                    ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_templates', function (Blueprint $table) {
            $table->dropForeign(['color_palette_id']);
        });

        Schema::dropIfExists('color_palettes');
    }
}
