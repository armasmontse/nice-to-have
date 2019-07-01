<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectiontypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sectiontypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->text('description');
            $table->string('admin_view_path');
            $table->boolean('protected')->default(false);
            $table->boolean('unlimited')->default(false);
            $table->boolean('sortable')->default(false);
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
        Schema::dropIfExists('sectiontypes');
    }
}
