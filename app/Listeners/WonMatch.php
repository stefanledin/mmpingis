<?php

namespace App\Listeners;

use App\Events\PlayerWonMatch;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Player;
use App\Match;

class WonMatch
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
     * @param  PlayerWonMatch  $event
     * @return void
     */
    public function handle(PlayerWonMatch $event)
    {
        $match = Match::find($event->player->match->id);
        $match->won_by = $event->player->id;
        $match->save();
    }
}
