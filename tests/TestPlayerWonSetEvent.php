<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Match;
use App\Player;

class TestPlayerScoredEvent extends TestCase
{
    use DatabaseTransactions;

    function test_it_works()
    {
        $player = new Player([
            'nickname' => 'Stefan',
            'points' => 10
        ]);
        $opponent = new Player([
            'nickname' => 'Fredrik',
            'points' => 9
        ]);
        $match = Match::create([
            'set' => 2
        ]);
        $match->players()->saveMany([$player, $opponent]);
        Event::fire(new App\Events\PlayerWonSet($player));

        $this->assertEquals(2, Match::find($match->id)->currentSet());
        $this->assertEquals(1, Player::find($player->id)->sets_won);
    }
    

}
