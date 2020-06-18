<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function(Blueprint $table){
            $table->increments('menuID',3001);
            $table->string('name',100);
            $table->text('details')->nullable();
            $table->float('price');
            $table->integer('servingsize');
            $table->mediumtext('image')->nullable();
            $table->integer('subcatid')->unsigned();
            $table->softDeletes();
            $table->foreign('subcatid')->references('subcatid')->on('sub_categories')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
