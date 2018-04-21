<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_applies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->string('project_number');
            $table->string('project_content');
            $table->unsignedInteger('project_id');
            $table->float('price');
            $table->string('use');
            $table->string('apply_date');
            $table->string('proposer');
            $table->unsignedInteger('proposer_id')->default(0);
            $table->string('approver')->nullable();
            $table->unsignedInteger('approver_id')->default(0);
            $table->string('pay_date')->nullable();
            $table->float('cash')->default(0);
            $table->float('transfer')->default(0);
            $table->float('other')->default(0);
            $table->string('bank')->nullable();
            $table->string('account')->nullable();
            $table->string('manager')->nullable();
            $table->unsignedInteger('manager_id')->default(0);
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('pay_applies');
    }
}
