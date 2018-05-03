<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockRecordListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_record_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('record_id');
            $table->unsignedInteger('material_id')->default(0);
            $table->integer('sum');
            $table->float('stock_cost',18,2);
            $table->float('stock_price',18,2);
            $table->integer('stock_number');
            $table->float('price',18,2);
            $table->float('cost',18,2);
            $table->integer('need_sum')->default(0);
            $table->float('need_cost',18,2)->default(0);
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
        Schema::dropIfExists('stock_record_lists');
    }
}
