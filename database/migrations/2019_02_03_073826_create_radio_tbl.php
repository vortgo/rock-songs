<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRadioTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radio', function (Blueprint $table) {
            $table->increments('id');
            $table->string('on_air');

            $table->integer('song_id')->unsigned()->nullable();
            $table->foreign('song_id')->references('id')->on('songs');

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
        Schema::dropIfExists('radio');
    }
}
