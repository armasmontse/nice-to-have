<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBagTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bag_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug',50)->unique();
            $table->string('label')->nullable();
            $table->boolean('event')->default(false);
            $table->boolean('special')->default(false);
            $table->boolean('register_user')->default(false);
            $table->boolean('protected')->default(false);
            $table->string('default_key',15);
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
        Schema::dropIfExists('bag_types');
    }
}
