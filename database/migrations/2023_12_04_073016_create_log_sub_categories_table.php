<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action')->nullable();
            $table->string('description')->nullable();
            $table->foreign('subcategory_id')->references('id')->on('sub_categories');
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
        Schema::dropIfExists('log_sub_categories');
    }
}
