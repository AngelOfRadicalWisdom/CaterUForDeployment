<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBundleDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bundle_details', function (Blueprint $table) {
            $table->increments('bundle_details_id',4001);
            $table->integer('menuID')->unsigned();
            $table->integer('bundleid')->unsigned();
            $table->integer('qty')->unsigned();
            $table->softDeletes();
            $table->foreign('menuID')->references('menuID')->on('menus')->onUpdate('cascade');
            $table->foreign('bundleid')->references('bundleid')->on('bundles')->onDelete('restrict')->onUpdate('cascade');
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bundle_details');
    }
}
