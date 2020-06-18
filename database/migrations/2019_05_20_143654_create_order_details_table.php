<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table){
            $table->engine='InnoDb';
            $table->increments('id',6001);
            $table->integer('orderQty');
            $table->integer('menuID')->unsigned();
            $table->string('status');
            $table->float('subtotal');
            $table->timestamp('date_ordered')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->integer('order_id')->unsigned();
            $table->integer('qtyServed')->unsigned()->nullable();
            $table->softDeletes();
            $table->foreign('order_id')->references('order_id')->on('orders')->onUpdate('cascade');
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
        Schema::dropIfExists('order_details');
    }
}
