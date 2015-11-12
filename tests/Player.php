<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Player;

class TestPlayer extends TestCase
{
    use DatabaseTransactions;

    public function test_player1_scores_first_point()
    {
        $match = Mockery::mock('App\Match');
        $player = Player::create();

        $event = (object) array(
            'score' => true
        );

        $player->scored($event->score)->in($match);
        
        $playerScore = $player->points()->in($match);

        $this->assertEquals(1, $playerScore);
    }

}
