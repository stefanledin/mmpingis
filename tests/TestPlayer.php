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
    }

}

