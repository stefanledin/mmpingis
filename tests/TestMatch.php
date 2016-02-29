<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Match;
use App\Player;

class TestMatch extends TestCase
{
    use DatabaseTransactions;

    public function test_start_new_match()
    {
        $player1 = new Player(['nickname' => 'Stefan']);
        $player2 = new Player(['nickname' => 'Fredrik']);
        
        $match =  Match::create();
        $match->players()->saveMany([$player1, $player2]);

        $score = $match->getScore();
        $set = $match->currentSet();
        
        $expected = (object) array(
            'Stefan' => 0,
            'Fredrik' => 0
        );

        $this->assertEquals($expected, $score);
        $this->assertEquals(1, $set);
        $this->assertCount(2, $match->players);
    }

    public function test_player1_scores_point()
    {
        $player1 = new App\Player(['nickname' => 'Stefan']);
        $player2 = new App\Player(['nickname' => 'Fredrik']);
        
        $match =  App\Match::create();
        $match->players()->saveMany([$player1, $player2]);      

        $player1->addPoint();

        $score = $match->getScore();

        $expected = (object) array(
            'Stefan' => 1,
            'Fredrik' => 0
        );

        $this->assertEquals($expected, $score);
    }

}
