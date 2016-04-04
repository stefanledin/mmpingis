<?php

namespace App\Listeners;

use App\Events\PlayerWonSet;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Match;
use App\Player;

class WonSet
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  PlayerWonSet  $event
     * @return void
     */
    public function handle(PlayerWonSet $event)
    {
        $match = Match::find($event->player->match->id);

        $player = Player::find($event->player->id);
        $player->sets_won += 1;
        $player->save();
    }
}
