<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('purchase_id');
            $table->string('date');
            $table->float('price');
            $table->float('pay_price')->default(0);
            $table->string('pay_date')->nullable();
            $table->string('worker')->nullable();
            $table->unsignedInteger('bank_id')->default(0);
            $table->unsignedInteger('check')->default(0);
            $table->unsignedInteger('worker_id')->default(0);
            $table->string('remark')->nullable();
            $table->tinyInteger('state')->default(1);
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
        Schema::dropIfExists('purchase_payments');
    }
}
