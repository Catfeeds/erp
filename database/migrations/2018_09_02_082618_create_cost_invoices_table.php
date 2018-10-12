<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cost_id');
            $table->string('date');
            $table->string('worker');
            $table->unsignedInteger('worker_id');
            $table->string('invoice_date');
            $table->string('number');
            $table->unsignedInteger('type');
            $table->float('without_tax',18,2);
            $table->float('tax',18,2);
            $table->float('with_tax',18,2);
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
        Schema::dropIfExists('cost_invoices');
    }
}
