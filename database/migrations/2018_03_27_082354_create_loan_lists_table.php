<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('borrower');
            $table->float('price');
            $table->string('apply_date');
            $table->string('reason');
            $table->string('pay_date')->nullable();
            $table->tinyInteger('pay_type')->default(1);
            $table->string('manager')->nullable();
            $table->string('bank')->nullable();
            $table->string('account')->nullable();
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
        Schema::dropIfExists('loan_lists');
    }
}
