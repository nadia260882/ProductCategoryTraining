<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Productimages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productimages', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('productId')->unsigned()->index()->nullable();
            $table->foreign('productId')->references('id')->on('products')->onDelete('cascade');
            $table->string('imageName');
            $table->boolean('imageStatus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productimages');
    }
}
