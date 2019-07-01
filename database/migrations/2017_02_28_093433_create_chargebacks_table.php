<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChargebacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chargebacks', function (Blueprint $table) {

            $table->unsignedInteger('event_id');
            $table->unsignedInteger('bag_id')->nullable();

            $table->text('info')->nullable();
            $table->decimal('amount', 12, 2);
            $table->boolean('revert')->default(false);

            $table  ->foreign('event_id')
                    ->references('id')
                    ->on('events')
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
        Schema::dropIfExists('chargebacks');
    }
}
