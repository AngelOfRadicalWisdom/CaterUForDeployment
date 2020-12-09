<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TemporaryCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
          $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('menuID')->unsigned()->nullable();
            $table->integer('bundleid')->unsigned()->nullable();
            $table->integer('qty');
            $table->foreign('order_id')->references('order_id')->on('orders')->onUpdate('cascade');
            $table->foreign('menuID')->references('menuID')->on('menus')->onUpdate('cascade');
            $table->foreign('bundleid')->references('bundleid')->on('bundles')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('carts');
    }
}
