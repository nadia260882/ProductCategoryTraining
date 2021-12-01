<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productCategories', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('productId')->unsigned()->index()->nullable();
            $table->foreign('productId')->references('id')->on('products')->onDelete('cascade');
            $table->integer('catId')->unsigned()->index()->nullable();
            $table->foreign('catId')->references('id')->on('categories')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productCategories');
    }
}
