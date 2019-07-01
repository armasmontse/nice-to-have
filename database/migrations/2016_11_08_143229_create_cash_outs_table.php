<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_outs', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('event_id')->unsigned();

            $table->decimal('total', 12, 2);
            $table->decimal('total_out', 12, 2);
            $table->text('info');
            $table->unsignedInteger('cash_out_status_id');
            $table->unsignedInteger('bank_account_id');

            $table  ->foreign('event_id')
                    ->references('id')
                    ->on('events')
                    ->onDelete('RESTRICT');

            $table  ->foreign('cash_out_status_id')
                    ->references('id')
                    ->on('cash_out_statuses')
                    ->onDelete('RESTRICT');

            $table  ->foreign('bank_account_id')
                    ->references('id')
                    ->on('bank_accounts')
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
        Schema::dropIfExists('cash_outs');
    }
}
