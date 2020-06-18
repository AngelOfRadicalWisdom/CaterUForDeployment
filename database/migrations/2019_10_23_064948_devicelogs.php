<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Devicelogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devicelogs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('tableno')->unsigned();
            $table->string('session_id');
            $table->timestamp('loggedin')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('loggedout')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();
            // $table->foreign('tableno')->references('tableno')->on('tables');
            // $table->foreign('session_id')->references('id')->on('sessions');

        });
        Schema::table('devicelogs', function (Blueprint $table) {
           $table->foreign('tableno')->references('tableno')->on('tables')->onUpdate('cascade');
            $table->foreign('session_id')->references('id')->on('sessions')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
