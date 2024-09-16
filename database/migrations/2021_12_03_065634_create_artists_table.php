<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('status')->default('0');
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email', 128)->nullable();
            $table->date('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->string('description_short')->nullable();
            $table->string('description_large')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file')->nullable();
            $table->string('avatar')->nullable();
            $table->string('module')->default('0')->nullable();
            $table->text('slug')->nullable();
            $table->text('country')->nullable();
            $table->text('phone')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artists');
    }
}
