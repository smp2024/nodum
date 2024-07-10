<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id')->nullable();

            $table->string('status')->nullable();
            $table->double('height')->nullable();
            $table->double('width')->nullable();
            $table->double('price_min')->nullable();
            $table->double('price_max')->nullable();

            $table->foreign('article_id')->references('id')->on('articles');

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
        Schema::dropIfExists('extra_items');
    }
}
