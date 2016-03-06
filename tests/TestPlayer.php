<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestPlayer extends TestCase
{
    use DatabaseTransactions;

    public function test_create_player()
    {
        $player = new App\Player;
        $player->nickname = 'Stefan';
        $player->save();

        $this->assertEquals('Stefan', $player->nickname);
        $this->assertEquals(0, $player->points);
    }

    public function test_add_one_point()
    {
        $player = new App\Player;
        $player->nickname = 'Fredrik';
        $player->save();

        $this->assertEquals(0, $player->points);

        $player->points += 1;
        $player->save();

        $this->assertEquals(1, $player->points);
    }

}

