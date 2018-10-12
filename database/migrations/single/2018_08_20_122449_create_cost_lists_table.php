<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('request_id');
            $table->string('pay_date');
            $table->float('cost',18,2)->default(0);
            $table->float('transfer',18,2)->default(0);
            $table->float('other',18,2)->default(0);
            $table->unsignedInteger('bank')->default(0);
            $table->string('worker')->nullable();
            $table->unsignedInteger('worker_id')->default(0);
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
        Schema::dropIfExists('cost_lists');
    }
}
