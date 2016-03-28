<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Match;

class StartNewSet extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $match;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Match $match)
    {
        $this->match = $match;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['mmpingis'];
    }
}
