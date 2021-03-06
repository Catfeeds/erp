<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id');
            $table->string('number');
            $table->string('date');
            $table->string('supplier');
            $table->unsignedInteger('supplier_id');
            $table->string('bank');
            $table->string('account');
            $table->string('condition');
            $table->string('content');
            $table->tinyInteger('type')->default(1);
            $table->tinyInteger('state')->default(1);
            $table->unsignedInteger('check')->default(0);
            $table->unsignedInteger('pass')->default(0);
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
        Schema::dropIfExists('purchases');
    }
}
