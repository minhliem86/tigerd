<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('sku_product')->nullable()->unique();
            $table->integer('price')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('stock_quality')->nullable();
            $table->string('img_url')->nullable();
            $table->boolean('hot')->default(0);
            $table->string('count_number')->nullable()->default(0);
            $table->integer('order')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
