<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_order', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('good_id');
            $table->unsignedInteger('order_id');
            $table->integer('quantity');
            $table->double('price_current');
            $table->double('tax_current');

            $table->foreign('good_id')->references('id')->on('goods');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('good_order');
    }
}
