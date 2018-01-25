<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_ideas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customer_name')->nullable();
            $table->string('slug')->nullable();
            $table->text('content')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('order')->nullable();
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
        Schema::drop('customer_ideas');
    }
}
