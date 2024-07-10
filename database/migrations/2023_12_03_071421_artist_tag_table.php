<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArtistTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artist_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tag_id')->nullable();
            $table->unsignedBigInteger('artist_id')->nullable();
            $table->softDeletes();

            $table->foreign('tag_id')->references('id')->on('tags');
            $table->foreign('artist_id')->references('id')->on('artists');
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
        Schema::dropIfExists('artist_tag');
    }
}
