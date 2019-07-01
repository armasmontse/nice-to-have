<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBagDiscounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bag_discounts', function (Blueprint $table) {
            $table->primary('bag_id');

            $table->integer('bag_id')->unsigned()->unique();
            $table->integer('discount_code_id')->unsigned();
            $table->decimal('amount', 12, 2);

            $table  ->foreign('bag_id')
                    ->references('id')
                    ->on('bags')
                    ->onDelete('RESTRICT');

            $table  ->foreign('discount_code_id')
                    ->references('id')
                    ->on('discount_codes')
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
        Schema::dropIfExists('bag_discounts');
    }
}
