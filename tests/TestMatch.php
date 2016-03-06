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
        
        $match = Match::create();
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
        $player1 = new Player(['nickname' => 'Stefan']);
        $player2 = new Player(['nickname' => 'Fredrik']);
        
        $match = Match::create();
        $match->players()->saveMany([$player1, $player2]);      

        $match->addPointFor($player1);

        $score = $match->getScore();

        $expected = (object) array(
            'Stefan' => 1,
            'Fredrik' => 0
        );

        $this->assertEquals($expected, $score);
    }

    public function test_player_wins_set()
    {
        $match = Match::create();
        $match->players()->saveMany([
            new Player([
                'nickname' => 'Stefan',
                'points' => 10
            ]),
            new Player([
                'nickname' => 'Fredrik',
                'points' => 9
            ]),
        ]);
        $player = Player::where('nickname', 'Stefan')->first();
        $match->addPointFor($player);

        $expected = (object) array(
            'Stefan' => 11,
            'Fredrik' => 9
        );

        $this->assertEquals($expected, $match->getScore());
    }

}
