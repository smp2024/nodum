<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('artist_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->string('status')->nullable();
            $table->string('module')->default('0')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file')->nullable();
            $table->text('description')->nullable();
            $table->double('height')->nullable();
            $table->double('width')->nullable();
            $table->double('price_min')->nullable();
            $table->double('price_max')->nullable();
            //$table->double('priceMax')->nullable();

            $table->softDeletes();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('subcategory_id')->references('id')->on('sub_categories');
            $table->foreign('artist_id')->references('id')->on('artists');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('articles');
    }
}
