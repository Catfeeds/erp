<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->unsignedInteger('warehouse_id')->default(0);
            $table->unsignedInteger('material_id')->default(0);
            $table->unsignedInteger('purchase_id')->default(0);
            $table->unsignedInteger('supplier_id')->default(0);
            $table->unsignedInteger('project_id')->default(0);
            $table->string('date');
            $table->string('supplier')->nullable();
            $table->string('purchase_number')->nullable();
            $table->string('worker');
            $table->unsignedInteger('worker_id');
            $table->float('price',18,2);
            $table->float('cost',18,2);
            $table->string('project_number')->nullable();
            $table->string('project_content')->nullable();
            $table->string('warehouse')->nullable();
            $table->integer('sum');
            $table->float('stock_cost',18,2);
            $table->float('stock_price',18,2);
            $table->integer('stock_number');
            $table->tinyInteger('type')->default(1);
            $table->tinyInteger('is_project')->default(0);
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
        Schema::dropIfExists('stock_records');
    }
}
