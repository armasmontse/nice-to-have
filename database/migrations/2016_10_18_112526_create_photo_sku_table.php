<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotoSkuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('photo_sku', function (Blueprint $table) {

            $table->integer('photo_id')->unsigned();
            $table->string('sku_sku', 45);

            $table->string('use')->default("thumbnail");
            $table->unsignedInteger('order')->nullable();
            $table->string('class')->nullable();

            $table->unique(['use', 'order' ,'sku_sku']);

            $table->unique(['photo_id', 'use' ,'sku_sku'] );

            $table  ->foreign('photo_id')
                    ->references('id')
                    ->on('photos')
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
        Schema::dropIfExists('photo_sku');
    }
}
