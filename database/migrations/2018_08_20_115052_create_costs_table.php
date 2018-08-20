<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id')->default(0);
            $table->string('apply_date')->nullable();
            $table->string('apply_price',18,2)->default(0);
            $table->unsignedInteger('supplier_id')->default(0);
            $table->unsignedInteger('pay_type')->default(0);
            $table->unsignedInteger('pay_detail')->default(0);
            $table->string('application')->nullable();
            $table->string('remark')->nullable();
            $table->tinyInteger('type')->default(1);
            $table->unsignedInteger('invoice_type')->default(0);
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
        Schema::dropIfExists('costs');
    }
}