<?php

namespace App\Listeners;

use App\Events\PlayerScoredPoint;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Match;
use App\Player;

class AddPoint
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PlayerScoredPoint  $event
     * @return void
     */
    public function handle(PlayerScoredPoint $event)
    {
        $player = $event->player;
        $match = Match::find($player->match->id);
        $match->addPointFor($player);
    }
}
