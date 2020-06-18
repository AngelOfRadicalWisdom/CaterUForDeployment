<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAprioriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apriori', function (Blueprint $table) {
            $table->increments('id',7001);
            $table->integer('menuID')->unsigned();
            $table->integer('groupNumber')->unsigned();
           $table->softDeletes();
          //  $table->timestamps();
          $table->foreign('menuID')->references('menuID')->on('menus')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apriori');
    }
}
