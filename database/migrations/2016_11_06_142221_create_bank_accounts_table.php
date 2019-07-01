<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->increments('id');

            $table->string('CLABE');
            $table->string('name')->default("");
            $table->string('bank')->default("");
            $table->string('account_number')->default("");
			$table->string('branch')->default("");

            $table->integer('user_id')->unsigned();

            $table  ->foreign('user_id')
                    ->references('id')
                    ->on('users')
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
        Schema::dropIfExists('bank_accounts');
    }
}
