<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestMatch extends TestCase
{
    use DatabaseTransactions;

    public function test_start_new_match()
    {
        $player1 = Mockery::mock('App\Player');
        $player2 = Mockery::mock('App\Player');
        
        $match = new App\Match;
        $match->player1 = $player1;
        $match->player2 = $player2;
        $match->save();

        $score = $match->getScore();
        $expected = (object) array(
            'player1' => 0,
            'player2' => 0
        );

        $set = $match->set();

        $this->assertEquals($expected, $score);
        $this->assertEquals(1, $set);
    }

}
