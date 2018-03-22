<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *项目基本信息表
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->string('name')->commit('name');
            $table->string('PartyA')->commit('PartyA');
            $table->float('price')->default(0)->commit('price');
            $table->integer('finishTime')->commit('finishTime');
            $table->string('pm')->commit('project manager');
            $table->integer('createTime')->commit('createTime');
            $table->string('condition')->commit('condition');
            $table->tinyInteger('state')->default(0);
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
        Schema::dropIfExists('projects');
    }
}
