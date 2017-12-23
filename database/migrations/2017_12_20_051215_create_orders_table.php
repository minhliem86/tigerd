<?php

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
            $table->increments('id');
            $table->dateTime('order_date')->nullable();
            $table->integer('sub_total');
            $table->string('discount')->nullable();
            $table->string('shipping_cost')->default(0);
            $table->string('total')->default(0);
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->integer('promotion_id')->unsigned();
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');
            $table->integer('shipcost_id')->unsigned();
            $table->foreign('shipcost_id')->references('id')->on('ship_payments')->onDelete('cascade');
            $table->integer('paymentmethod_id')->unsigned();
            $table->foreign('paymentmethod_id')->references('id')->on('payment_methods')->onDelete('cascade');
            $table->integer('shipstatus_id')->unsigned();
            $table->foreign('shipstatus_id')->references('id')->on('shipstatus')->onDelete('cascade');
            $table->integer('paymentstatus_id')->unsigned();
            $table->foreign('paymentstatus_id')->references('id')->on('paymentstatus')->onDelete('cascade');
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
        Schema::drop('orders');
    }
}
