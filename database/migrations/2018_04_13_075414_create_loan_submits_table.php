<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanSubmitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_submits', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('number');
            $table->tinyInteger('type')->default(1);
            $table->string('date');
            $table->float('price');
            $table->string('loan_user');
            $table->string('checker')->nullable();
            $table->unsignedInteger('checker_id')->default(0);
            $table->string('worker')->nullable();
            $table->unsignedInteger('worker_id')->default(0);
            $table->unsignedInteger('passer_id')->default(0);
            $table->string('passer')->nullable();
            $table->tinyInteger('state')->default(1);
            $table->unsignedInteger('project_id')->default(0);
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
        Schema::dropIfExists('loan_submits');
    }
}
