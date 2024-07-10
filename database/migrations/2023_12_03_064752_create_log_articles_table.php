<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action')->nullable();
            $table->string('description')->nullable();
            $table->foreign('article_id')->references('id')->on('articles');
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
        Schema::dropIfExists('log_articles');
    }
}
