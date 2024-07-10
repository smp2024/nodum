<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('new_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();

            $table->string('type')->nullable();
            $table->string('section')->nullable();
            $table->string('content')->nullable();
            $table->softDeletes();

            $table->foreign('new_id')->references('id')->on('news');
            $table->foreign('project_id')->references('id')->on('projects');


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
        Schema::dropIfExists('descriptions');
    }
}
