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

    public function test_player2_is_the_oppenent_of_player1()
    {
        $player1 = new Player(['nickname' => 'Stefan']);
        $player2 = new Player(['nickname' => 'Fredrik']);
        
        $match = Match::create();
        $match->players()->saveMany([$player1, $player2]);      

        $this->assertEquals($player2->nickname, $match->getOppenentFor($player1)->nickname);
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
        $this->assertEquals('Stefan', $match->getLeader()->nickname);
    }

    public function test_player_2_evens_the_score()
    {
        $player1 = new Player([
            'nickname' => 'Stefan',
            'points' => 1
        ]);
        $player2 = new Player([
            'nickname' => 'Fredrik',
            'points' => 0
        ]);
        
        $match = Match::create();
        $match->players()->saveMany([$player1, $player2]);      

        $match->addPointFor($player2);

        $score = $match->getScore();

        $expected = (object) array(
            'Stefan' => 1,
            'Fredrik' => 1
        );

        $this->assertEquals($expected, $score);
    }
    

    public function test_player_wins_set()
    {
        $player1 = new Player([
            'nickname' => 'Stefan',
            'points' => 10
        ]);
        $player2 = new Player([
            'nickname' => 'Fredrik',
            'points' => 9
        ]);
        
        $match = Match::create();
        $match->players()->saveMany([$player1, $player2]);
        $match->addPointFor($player1);

        $expected = (object) array(
            'Stefan' => 11,
            'Fredrik' => 9
        );

        $this->assertEquals($expected, $match->getScore());
        $this->assertEquals('Stefan', $match->getLeader()->nickname);
        $this->assertEquals(1, $player1->sets_won);
        $this->assertEquals(0, $player2->sets_won);
    }

    public function test_player1_scores_point_when_tied_at_ten()
    {
        $player1 = new Player([
            'nickname' => 'Stefan',
            'points' => 10
        ]);
        $player2 = new Player([
            'nickname' => 'Fredrik',
            'points' => 10
        ]);
        
        $match = Match::create();
        $match->players()->saveMany([$player1, $player2]);
        $match->addPointFor($player1);

        $expected = (object) array(
            'Stefan' => 11,
            'Fredrik' => 10
        );

        $this->assertEquals($expected, $match->getScore());
        $this->assertEquals(0, $player1->sets_won);
        $this->assertEquals(0, $player2->sets_won);
    }

    public function test_player_1_wins_long_set()
    {
        $player1 = new Player([
            'nickname' => 'Stefan',
            'points' => 16
        ]);
        $player2 = new Player([
            'nickname' => 'Fredrik',
            'points' => 15
        ]);
        
        $match = Match::create();
        $match->players()->saveMany([$player1, $player2]);
        $match->addPointFor($player1);

        $expected = (object) array(
            'Stefan' => 17,
            'Fredrik' => 15
        );

        $this->assertEquals($expected, $match->getScore());
        $this->assertEquals(1, $player1->sets_won);
        $this->assertEquals(0, $player2->sets_won);
    }
    
    /*public function test_player1_wins_set_and_player2_scores_first_in_second_set()
    {
        $player1 = new Player([
            'nickname' => 'Stefan',
            'points' => 10
        ]);
        $player2 = new Player([
            'nickname' => 'Fredrik',
            'points' => 9
        ]);
        
        $match = Match::create();
        $match->players()->saveMany([$player1, $player2]);
        $match->addPointFor($player1);

        $expected = (object) array(
            'Stefan' => 11,
            'Fredrik' => 9
        );

        $this->assertEquals($expected, $match->getScore());
        $this->assertEquals(1, $player1->sets_won);
        $this->assertEquals(0, $player2->sets_won);

        $match->addPointFor($player2);

        $expected = (object) array(
            'Stefan' => 0,
            'Fredrik' => 1
        );

        $this->assertEquals(2, $match->currentSet());
        $this->assertEquals($expected, $match->getScore());
        $this->assertEquals(1, $player1->sets_won);
        $this->assertEquals(0, $player2->sets_won);
    }*/

}
