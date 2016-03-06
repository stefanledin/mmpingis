<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Player;

class Match extends Model
{

    /**
     * Returns an object with the score of each player
     * @return object score
     */
    public function getScore()
    {
        $score = [];
        foreach ($this->players()->get() as $player) {
            $score[$player->nickname] =  $player->points;
        }
        return (object) $score;
    }

    /**
     * Returns the Player that currently has most
     * points in the game.
     * @return Player player
     */
    public function getLeader()
    {
        $players = $this->players->sortByDesc('points');
        return $players->first(); 
    }

    public function getOppenent(Player $player)
    {
        $opponent = $this->players()->where('id', '!=', $player->id);
        return $opponent->first();
    }

    public function addPointFor(Player $player)
    {
        $player->points += 1;

        if ($player->points > 10) {
            $player->sets_won += 1;
            // Om motståndaren har mindre än 10 poäng så vann spelaren setet.
            // Om motståndaren har 10 eller mer poäng
        }
        $player->save();
    }

    public function currentSet()
    {
        return 1;
    }
    

    public function players()
    {
        return $this->hasMany('App\Player');
    }
    
}
