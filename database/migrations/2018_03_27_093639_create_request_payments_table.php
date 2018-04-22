<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->string('team');
            $table->string('manager');
            $table->string('project_number');
            $table->string('project_content');
            $table->string('project_manager');
            $table->string('request_date');
            $table->string('passer')->nullable();
            $table->string('checker')->nullable();
            $table->string('applier')->nullable();
            $table->unsignedInteger('checker_id')->default(0);
            $table->unsignedInteger('passer_id')->default(0);
            $table->unsignedInteger('applier_id')->default(0);
            $table->tinyInteger('state')->default(1);
            $table->float('price');
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
        Schema::dropIfExists('request_payments');
    }
}
