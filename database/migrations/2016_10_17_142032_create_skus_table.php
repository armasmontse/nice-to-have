<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skus', function (Blueprint $table) {
            $table->string('sku', 45);
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('local_shipping_rate', 12, 2)->default(0);
            $table->decimal('national_shipping_rate', 12, 2)->default(0);
            $table->integer('discount')->default(0);
            $table->boolean('default')->default(false);

            $table->integer('product_id')->unsigned()->nullable();

            $table->primary('sku');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('RESTRICT');

            $table->timestamps();
        });

        Schema::create('language_sku', function (Blueprint $table) {

            $table->integer('language_id')->unsigned();
            $table->string('sku_sku', 45);

            $table->text('description')->nullable();

            $table->primary(['language_id','sku_sku']);

            $table  ->foreign('language_id')
                    ->references('id')
                    ->on('languages')
                    ->onDelete('RESTRICT');

            $table  ->foreign('sku_sku')
                    ->references('sku')
                    ->on('skus')
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
        Schema::dropIfExists('language_sku');
        Schema::dropIfExists('skus');
    }
}
