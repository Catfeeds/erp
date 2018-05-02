<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildPayFinishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('build_pay_finishes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_team');
            $table->string('number');
            $table->string('apply_date');
            $table->float('apply_price',18,2);
            $table->string('payee');
            $table->string('bank');
            $table->string('account');
            $table->string('pay_date')->nullable();
            $table->float('pay_price',18,2)->default(0);
            $table->string('pay_bank')->nullable();
            $table->string('pay_account')->nullable();
            $table->string('remark')->nullable();
            $table->string('pay_worker')->nullable();
            $table->string('worker')->nullable();
            $table->string('checker')->nullable();
            $table->string('passer')->nullable();
            $table->unsignedInteger('pay_worker_id')->default(0);
            $table->unsignedInteger('worker_id')->default(0);
            $table->unsignedInteger('checker_id')->default(0);
            $table->unsignedInteger('passer_id')->default(0);
            $table->tinyInteger('state')->default(1);
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
        Schema::dropIfExists('build_pay_finishes');
    }
}
