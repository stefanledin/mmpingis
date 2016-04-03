<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Match;
use App\Player;

class PlayerWonMatch extends TestCase
{
    use DatabaseTransactions;

    public function test_player1_wins_match()
    {
        $player1 = new Player([
            'points' => 10,
            'sets_won' => 1
        ]);
        $player2 = new Player([
            'points' => 9,
            'sets_won' => 1
        ]);
        $match = Match::create();
        $match->players()->saveMany([$player1, $player2]);

        $match->addPointFor($player1);

        $this->assertEquals($player1->id, Match::find($match->id)->won_by);
        $this->assertEquals(2, Player::find($player1->id)->sets_won);
    }
    
}


