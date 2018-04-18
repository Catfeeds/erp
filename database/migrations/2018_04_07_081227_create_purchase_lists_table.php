<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('purchase_id');
            $table->unsignedInteger('budget_id')->default(0);
            $table->unsignedInteger('material_id')->default(0);
            $table->integer('number');
            $table->float('price')->default(0);
            $table->float('cost');
            $table->string('warranty_date');
            $table->string('warranty_time');
            $table->integer('received')->default(0);
            $table->integer('need')->default(0);
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
        Schema::dropIfExists('purchase_lists');
    }
}
