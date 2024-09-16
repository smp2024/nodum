<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role')->nullable();
            $table->integer('status')->default('0');
            $table->unsignedBigInteger('artist_id')->nullable();
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email', 128)->unique();
            $table->date('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file')->nullable();
            $table->string('avatar')->nullable();
            $table->string('module')->default('0')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('password_code')->nullable();
            $table->string('verification_code')->nullable();
            $table->text('permissions')->nullable();
            $table->text('slug')->nullable();
            $table->text('country')->nullable();
            $table->text('phone')->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('artist_id')->references('id')->on('artists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
