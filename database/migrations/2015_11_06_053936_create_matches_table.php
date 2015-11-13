<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('player1')->unsigned()->nullable();
            $table->integer('player2')->unsigned()->nullable();
            $table->foreign('player1')->references('id')->on('players')->onDelete('cascade');
            $table->foreign('player2')->references('id')->on('players')->onDelete('cascade');
            $table->integer('set');
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
        Schema::drop('matches');
    }
}
