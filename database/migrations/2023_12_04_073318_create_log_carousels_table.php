<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogCarouselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_carousels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('carousel_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action')->nullable();
            $table->string('description')->nullable();
            $table->foreign('carousel_id')->references('id')->on('carousels');
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
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
        Schema::dropIfExists('log_carousels');
    }
}
