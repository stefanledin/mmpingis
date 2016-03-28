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
        Schema::create('players', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname');
            $table->timestamps();
        });

        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('set')->default(1);
            $table->timestamps();
        });
        Schema::table('players', function (Blueprint $table) {
            $table->integer('points')->default(0);
            $table->integer('sets_won')->default(0);
            $table->integer('match_id')->unsigned()->nullable();
            $table->foreign('match_id')->references('id')->on('matches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('matches');
        Schema::drop('players');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
