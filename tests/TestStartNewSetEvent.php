<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Match;
use App\Player;

class TestStartNewSetEvent extends TestCase
{
    use DatabaseTransactions;

    function test_it_works()
    {
        $player = new Player([
            'nickname' => 'Stefan',
            'points' => 11
        ]);
        $opponent = new Player([
            'nickname' => 'Fredrik',
            'points' => 9
        ]);
        $match = Match::create();
        $match->players()->saveMany([$player, $opponent]);

        $this->assertEquals(1, $match->currentSet());

        Event::fire(new App\Events\StartNewSet($match));

        $expected = (object) array(
            'Stefan' => 0,
            'Fredrik' => 0
        );

        $this->assertEquals(2, Match::find($match->id)->currentSet());
        $this->assertEquals($expected, Match::find($match->id)->getScore());
    }
    

}

