<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_product', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->integer('product_id_related')->unsigned();

            $table->unique(['product_id','product_id_related']);

            $table  ->foreign('product_id')
                    ->references('id')
                    ->on('products')
                    ->onDelete('RESTRICT');

            $table  ->foreign('product_id_related')
                    ->references('id')
                    ->on('products')
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
        Schema::dropIfExists('product_product');
    }
}
