<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('purchase_id');
            $table->string('date');
            $table->string('invoice_date');
            $table->string('number');
            $table->string('type');
            $table->float('without_tax');
            $table->float('tax');
            $table->float('with_tax');
            $table->unsignedInteger('worker');
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
        Schema::dropIfExists('purchase_invoices');
    }
}
