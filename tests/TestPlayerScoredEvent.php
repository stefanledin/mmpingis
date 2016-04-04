<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Match;
use App\Player;

class TestPlayerScoredEvent extends TestCase
{
    use DatabaseTransactions;

    function test_event_is_working()
    {
        $player = new Player([
            'nickname' => 'Stefan',
            'points' => 0
        ]);
        $opponent = new Player([
            'nickname' => 'Fredrik',
            'points' => 0
        ]);
        $match = Match::create();
        $match->players()->saveMany([$player, $opponent]);
        Event::fire(new App\Events\PlayerScoredPoint($player, true));

        $this->assertEquals(1, $player->points);
        $this->assertEquals(0, $opponent->points);
    }

    function test_starts_new_set()
    {
        $player = new Player([
            'nickname' => 'Stefan',
            'points' => 10
        ]);
        $opponent = new Player([
            'nickname' => 'Fredrik',
            'points' => 9
        ]);
        $match = Match::create();
        $match->players()->saveMany([$player, $opponent]);
        Event::fire(new App\Events\PlayerScoredPoint($player, true));

        $this->assertEquals(11, $player->points);
        $this->assertEquals(9, $opponent->points);

    }
    

}

