<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->engine = 'InnoDb';
            $table->increments('order_id',5001);
            $table->integer('custid')->unsigned()->nullable();
            $table->integer('empid')->unsigned();
            $table->integer('tableno')->unsigned();
            $table->string('discountType',100)->nullable();
            $table->float('discount')->nullable();
            $table->float('discountedTotal')->nullable();
            $table->float('total');
            $table->float('vatExemptRate')->nullable();
            $table->float('VATableSales')->nullable();
            $table->float('vat')->nullable();
            $table->float('cashTender')->nullable();
            $table->float('change')->nullable();
            $table->string('status');
            $table->timestamp('date_ordered')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();
            $table->foreign('custid')->references('custid')->on('customers')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('empid')->references('empid')->on('employees')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('tableno')->references('tableno')->on('tables')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
