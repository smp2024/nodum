<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('n_galleries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('new_id')->nullable();
            $table->string('after')->nullable();
            $table->string('mobile')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->softDeletes();
            $table->foreign('new_id')->references('id')->on('news');
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
        Schema::dropIfExists('n_galleries');
    }
}
