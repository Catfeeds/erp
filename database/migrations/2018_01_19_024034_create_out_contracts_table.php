<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutContractsTable extends Migration
{
    /**
     * Run the migrations.
     *分标合同情况
     * @return void
     */
    public function up()
    {
        Schema::create('out_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id');
            $table->string('unit');
            $table->float('price');
            $table->string('remark');
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
        Schema::dropIfExists('out_contracts');
    }
}
