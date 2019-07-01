<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSubcatypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_subtype', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->integer('subtype_id')->unsigned();

            $table->unique(['product_id','subtype_id']);

            $table  ->foreign('product_id')
                    ->references('id')
                    ->on('products')
                    ->onDelete('RESTRICT');

            $table  ->foreign('subtype_id')
                    ->references('id')
                    ->on('subtypes')
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
        Schema::dropIfExists('product_subtype');
    }
}
