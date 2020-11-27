<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TemporaryOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporary_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kId');
            $table->integer('order_id')->unsigned();
            $table->integer('menuID')->unsigned()->nullable();
            $table->integer('bundleid')->unsigned()->nullable();
            $table->integer('orderQty');
            $table->string('status');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('kId')->references('id')->on('kitchenrecords');
            $table->foreign('order_id')->references('order_id')->on('orders');
            $table->foreign('menuID')->references('menuID')->on('menus');
            $table->foreign('bundleid')->references('bundleid')->on('bundles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temporary_orders');
    }
}
