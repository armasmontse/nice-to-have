<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBagShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bag_shippings', function (Blueprint $table) {
            $table->primary('bag_id');

            $table->integer('bag_id')->unsigned()->unique();

            $table->text('info')->nullable();
            $table->decimal('rate',12,2);
            $table->string('method',45);
            $table->string('tracking_code',22);

            $table->integer('address_id')->unsigned()->nullable();

            $table  ->foreign('address_id')
                    ->references('id')
                    ->on('addresses')
                    ->onDelete('RESTRICT');

            //$table->boolean('estafeta_guide')->default(false);

            $table  ->foreign('bag_id')
                    ->references('id')
                    ->on('bags')
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
        Schema::dropIfExists('bag_shippings');
    }
}
