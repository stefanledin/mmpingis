<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestAddPoint extends TestCase
{
    public function test_add_one_point()
    {
        $player = Mockery::mock('App\Player');
        $match = Mockery::mock('App\Match')
            ->shouldReceive('addPointFor')
            ->with($player)
            ->once()
            ->mock();

        $point = new App\Point();
        $point->inMatch($match);
        $point->by($player);
        $point->add();
    }
}
