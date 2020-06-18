<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SubCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories',function(Blueprint $table){
            $table->increments('subcatid',2001);
            $table->string('subname',100);
            $table->integer('categoryid')->unsigned();
            $table->softDeletes();
            $table->foreign('categoryid')->references('categoryid')->on('categories')->onUpdate('cascade');;
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_categories');
    }
}
