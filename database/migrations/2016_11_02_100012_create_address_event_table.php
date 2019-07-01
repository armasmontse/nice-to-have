<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_event', function (Blueprint $table) {

            $table->integer('address_id')->unsigned();
            $table->integer('event_id')->unsigned();

            $table->string('use')->default("main");

            $table->primary('event_id')->unique();
            
            $table->unique(['address_id','event_id']);

            $table  ->foreign('address_id')
                    ->references('id')
                    ->on('addresses')
                    ->onDelete('RESTRICT');

            $table  ->foreign('event_id')
                    ->references('id')
                    ->on('events')
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
        Schema::dropIfExists('address_event');
    }
}
