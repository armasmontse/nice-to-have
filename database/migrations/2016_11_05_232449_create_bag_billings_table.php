<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBagBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bag_billings', function (Blueprint $table) {
            $table->primary('bag_id');

            $table->integer('bag_id')->unsigned()->unique();

            $table->string('rfc')->default("");
            $table->text('razon_social')->nullable();
            $table->text('info')->nullable();
            $table->text('status')->nullable();
            $table->boolean('request')->default(false);

			$table->integer('address_id')->unsigned()->nullable();

            $table  ->foreign('address_id')
                    ->references('id')
                    ->on('addresses')
                    ->onDelete('RESTRICT');

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
        Schema::dropIfExists('bag_billings');
    }
}
