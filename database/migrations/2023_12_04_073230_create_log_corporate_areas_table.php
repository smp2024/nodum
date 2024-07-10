<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogCorporateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_corporate_areas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('corporate_area_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action')->nullable();
            $table->string('description')->nullable();
            $table->foreign('corporate_area_id')->references('id')->on('corporate_areas');
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
        Schema::dropIfExists('log_corporate_areas');
    }
}
