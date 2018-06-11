<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipstatus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code')->default(1)->comment('1: Trong Kho, 2: Đang Vận Chuyển Hoặc Sử Lý, 3: Đã Nhận Hàng');
            $table->text('description')->nullable();
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
        Schema::drop('shipstatus');
    }
}
