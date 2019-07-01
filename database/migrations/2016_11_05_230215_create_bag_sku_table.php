<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBagSkuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bag_sku', function (Blueprint $table) {
            // $table->increments('id');

            $table->string('sku_sku', 45);
            $table->integer('bag_id')->unsigned();
			$table->integer('parent_bag_id')->unsigned()->nullable();

            $table->integer('quantity');
            $table->decimal('price', 12, 2)->nullable();
            // $table->decimal('cost', 12, 2);
            $table->decimal('shipping_rate', 12, 2)->nullable();
            $table->integer('discount')->nullable();

            $table->unique(['parent_bag_id','sku_sku','bag_id']);

            $table  ->foreign('sku_sku')
                    ->references('sku')
                    ->on('skus')
                    ->onDelete('RESTRICT');

            $table  ->foreign('bag_id')
                    ->references('id')
                    ->on('bags')
                    ->onDelete('RESTRICT');
            $table->timestamps();

			$table  ->foreign('parent_bag_id')
					->references('id')
					->on('bags')
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
        Schema::dropIfExists('bag_sku');
    }
}
