<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bails', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id');
            $table->string('unit');
            $table->float('price');
            $table->string('term');
            $table->float('cost');
            $table->string('other')->nullable();
            $table->string('pay_date');
            $table->float('pay_price');
            $table->string('payee');
            $table->string('bank');
            $table->string('bank_account');
            $table->string('condition')->nullable();
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
        Schema::dropIfExists('bails');
    }
}
