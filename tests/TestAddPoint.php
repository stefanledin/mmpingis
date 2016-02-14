<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Player;
use App\Match;

class TestAddPoint extends TestCase
{
    use DatabaseTransactions;

    public function test_player1_scores_first_point()
    {
        $player1 = Player::create();
        $player2 = Player::create();
        $match = Match::create(['set' => 1]);
        $match->players()->saveMany([$player1, $player2]);

        $player1->scored();

        $this->assertEquals(1, $match->set);
        $this->assertEquals(1, $player1->points());
        $this->assertEquals(0, $player2->points());
    }

    public function test_player1_wins_first_set_and_player2_scores_takes_lead_in_second_set()
    {
        $player1 = Player::create(['points_set1' => 10]);
        $player2 = Player::create(['points_set1' => 9]);
        $match = Match::create(['set' => 1]);
        $match->players()->saveMany([$player1, $player2]);

        $player1->scored();

        $this->assertEquals(1, $match->set);
        $this->assertEquals(11, $player1->points());
        $this->assertEquals(9, $player2->points());

        $player2->scored();

        $this->assertEquals(2, $match->set);
        $this->assertEquals(0, $player1->points());
        $this->assertEquals(1, $player2->points());
    }
}
