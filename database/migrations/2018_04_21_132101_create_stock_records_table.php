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
            $table->unsignedInteger('purchase_id')->default(0);
            $table->unsignedInteger('supplier_id')->default(0);
            $table->unsignedInteger('project_id')->default(0);
            $table->string('date');
            $table->string('supplier')->nullable();
            $table->string('purchase_number')->nullable();
            $table->string('worker');
            $table->string('returnee')->nullable();
            $table->unsignedInteger('worker_id');
            $table->string('project_number')->nullable();
            $table->string('project_content')->nullable();
            $table->string('warehouse')->nullable();
            $table->float('cost',18,2);
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
