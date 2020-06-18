<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBundleMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bundle_menus', function (Blueprint $table) {
            $table->integer('bundleid')->unsigned()->primary();
            $table->float('price');
            $table->integer('servingsize');
            $table->string('name', 100);
            $table->text('details')->nullable();
            $table->mediumtext('image')->nullable();
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
        Schema::dropIfExists('bundle_menus');
    }
}
