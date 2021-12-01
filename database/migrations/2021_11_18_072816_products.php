<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('productCode');
            $table->string('productName');
            $table->integer('quantity');
            $table->dateTime('added_date');
            $table->dateTime('modify_date');
            $table->decimal('unitPrice',10,2);
            $table->decimal('salePrice',10,2);
            $table->integer('orderUnit');
            $table->boolean('productStatus')->default(0);
            $table->boolean('i_deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
