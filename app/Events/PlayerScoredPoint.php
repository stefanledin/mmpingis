<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Player;

class PlayerScoredPoint extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $player;
    public $addPoint;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Player $player, bool $addPoint)
    {
        $this->player = $player;
        $this->addPoint = $addPoint;
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
