<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->unsignedInteger('order')->nullable();
            $table->timestamps();

            $table->unique(['product_id','order']);

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('RESTRICT');
        });

        Schema::create('language_product_section', function (Blueprint $table) {

            $table->integer('language_id')->unsigned();
            $table->integer('product_section_id')->unsigned();

            $table->string('title')->default("");
            $table->text('content')->nullable();

            $table->primary(['language_id','product_section_id']);

            $table  ->foreign('language_id')
                    ->references('id')
                    ->on('languages')
                    ->onDelete('RESTRICT');

            $table  ->foreign('product_section_id')
                    ->references('id')
                    ->on('product_sections')
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
        Schema::dropIfExists('language_product_section');
        Schema::dropIfExists('product_sections');
    }
}
