<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmployeeTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeetime', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->timestamp('timein')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->timestamp('timeout')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employeetime');
    }
}
