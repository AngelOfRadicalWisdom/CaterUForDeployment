<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Kitchen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('kitchen',function(Blueprint $table){
            $table->increments('id',2001);
            $table->integer('menuID')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->integer('orderQty')->unsigned();
            $table->string('status');
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
        //
    }
}
