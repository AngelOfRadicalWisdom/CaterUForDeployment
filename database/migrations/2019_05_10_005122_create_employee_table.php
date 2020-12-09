<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->integer('empid')->unsigned()->primary();
            $table->string('empfirstname', 100);
            $table->string('emplastname', 100);
            $table->string('username',100);
            $table->string('password');
            $table->mediumtext('image')->nullable();
            $table->string('position',100);
            $table->rememberToken();
            $table->softDeletes();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
