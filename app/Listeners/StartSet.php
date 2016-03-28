<?php

namespace App\Listeners;

use App\Events\StartNewSet;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StartSet
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
     * @param  StartNewSet  $event
     * @return void
     */
    public function handle(StartNewSet $event)
    {
        $match = $event->match;
        $match->startNewSet();
        $match->resetPlayerPoints();
    }
}
