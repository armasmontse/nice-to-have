<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();

            $table->string('key', 12)->unique();
            $table->string('name');
            $table->string('slug')->nullable()->unique();
            $table->text('feted_names');
            $table->text('description');

            $table->dateTime('date');
            $table->string('timezone')->default("America/Mexico_City");

            $table->boolean('accept')->default(true);

            $table->boolean('exclusive')->default(true);

            $table->integer('event_status_id')->unsigned();

            $table->morphs('typeable');

            $table  ->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('RESTRICT');

            $table  ->foreign('event_status_id')
                    ->references('id')
                    ->on('event_statuses')
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
        Schema::dropIfExists('events');
    }
}
