<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('build_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_team');
            $table->string('date');
            $table->string('worker');
            $table->unsignedInteger('worker_id')->default(0);
            $table->string('invoice_date');
            $table->string('number');
            $table->string('type');
            $table->float('without_tax',18,2)->default(0);
            $table->float('tax',18,2)->default(0);
            $table->float('with_tax',18,2)->default(0);
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
        Schema::dropIfExists('build_invoices');
    }
}
