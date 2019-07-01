<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key',15)->unique();

            $table->text('message')->nullable();
            $table->boolean('print_message')->default(false);

            $table->unsignedInteger('bag_status_id');
			$table->text('status_info')->nullable();
			
            $table->unsignedInteger('bag_type_id');

            $table->timestamp('purshased_at')->nullable();

            $table->integer('event_id')->unsigned()->nullable();

            $table  ->foreign('event_id')
                    ->references('id')
                    ->on('events')
                    ->onDelete('RESTRICT');


            $table  ->foreign('bag_status_id')
                    ->references('id')
                    ->on('bag_statuses')
                    ->onDelete('RESTRICT');

            $table  ->foreign('bag_type_id')
                    ->references('id')
                    ->on('bag_types')
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
        Schema::dropIfExists('bags');
    }
}
