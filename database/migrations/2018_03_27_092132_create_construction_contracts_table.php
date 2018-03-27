<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConstructionContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('construction_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->string('date');
            $table->string('team');
            $table->string('manager');
            $table->string('project_number');
            $table->string('project_content');
            $table->string('project_manager');
            $table->string('manager')->nullable();
            $table->string('checker')->nullable();
            $table->string('reviewer')->nullable();

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
        Schema::dropIfExists('construction_contracts');
    }
}
