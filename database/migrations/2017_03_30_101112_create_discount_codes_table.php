<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 15)->unique();
            $table->text('description')->nullable();
            $table->date('initial_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('value', 12, 2)->default(0)->nullable();
            $table->boolean('unique')->default(false);

            $table->integer('discount_code_type_id')->unsigned();

            $table  ->foreign('discount_code_type_id')
                    ->references('id')
                    ->on('discount_codes_types')
                    ->onDelete('RESTRICT');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_codes');
    }
}
