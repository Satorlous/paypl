<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('good_id');
            $table->string('link');
            $table->integer('media_type_id');
            $table->text('description')->nullable();

            $table->foreign('good_id')->references('id')->on('goods');
            $table->foreign('media_type_id')->references('id')->on('media_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
