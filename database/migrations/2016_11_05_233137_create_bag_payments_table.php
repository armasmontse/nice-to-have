<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBagPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bag_payments', function (Blueprint $table) {
            $table->primary('bag_id');

            $table->integer('bag_id')->unsigned()->unique();

            $table->string('payable_id');
            $table->string('payable_type');
            $table->string('payable_status');

            $table->decimal('currency',12,2);
            $table->string('currency_type',6);

            $table->decimal('total', 12, 2);
			$table->decimal('total_credit', 12, 2)->default(0.0)->nullable();

			$table->timestamp('paid_at')->nullable();
			$table->text('extra_info')->nullable();

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
        Schema::dropIfExists('bag_payments');
    }
}
