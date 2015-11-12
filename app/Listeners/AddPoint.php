<?php

namespace App\Listeners;

use App\Events\PlayerScoredPoint;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        new Point($event);

        // 1. Hitta aktuella matchen
        $match = Match::findInSomeWay();
        $player = Player::find($event->player);
        // 2. Uppdatera ställningen.
        $player->scored($event->score)->in($match);
        // 3. Avsluta pågående set om någon vunnit.
        if ($player->wonSet()->in($match)) {
            // 4. Avsluta matchen om spelaren vunnit
            if ($player->wonMatch($match)) {
                $match->isFinished();
            }
            // 5. Påbörja nytt set.
            else {
                $match->newSet();
            }
        }
    }
}
