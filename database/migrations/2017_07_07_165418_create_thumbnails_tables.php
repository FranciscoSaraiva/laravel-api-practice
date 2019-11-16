<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThumbnailsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thumbnail', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url', 200);
            $table  ->integer('thumbnail_type_id')
                    ->references('id')->on('thumbnail_type');
            $table  ->integer('video_id')
                    ->references('id')->on('video');
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
        Schema::drop('thumbnail');
    }
}
