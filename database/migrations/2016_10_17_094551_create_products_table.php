<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',10)->unique();
            $table->integer('provider_id')->unsigned();
			$table->integer('publish_id')->unsigned()->nullable();
			$table->timestamp('publish_at')->nullable();

            $table  ->foreign('provider_id')
                    ->references('id')
                    ->on('providers')
                    ->onDelete('RESTRICT');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('language_product', function (Blueprint $table) {
            $table->integer('language_id')->unsigned();
            $table->integer('product_id')->unsigned();

            $table->text('description')->nullable();
            $table->string('title',255)->default("");
            $table->string('slug',255)->unique()->nullable();

            $table->primary(['language_id','product_id']);

            $table  ->foreign('language_id')
                    ->references('id')
                    ->on('languages')
                    ->onDelete('RESTRICT');

            $table  ->foreign('product_id')
                    ->references('id')
                    ->on('products')
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
        Schema::dropIfExists('language_product');
        Schema::dropIfExists('products');
    }
}
