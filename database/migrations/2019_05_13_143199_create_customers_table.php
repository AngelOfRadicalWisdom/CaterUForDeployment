<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('custid');
            $table->string('name',100)->nullable();
            $table->string('phonenumber')->nullable();
            $table->integer('partysize')->nullable();
            $table->string('status')->nullable();
            $table->integer('tableno')->nullable();
            $table->timestamp('time_notified')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->softDeletes();

    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
