<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFramesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frames', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('n')->unsigned();
            $table->integer('game_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unique(array('game_id', 'n'));
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
        Schema::drop('frames');
    }
}
