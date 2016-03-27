<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Player;

class Match extends Model
{

    protected $set = 1;

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
     * Returns the difference between both players points
     *
     * @return int
     */
    public function getScoreDifference(Player $player)
    {
        $opponent = $this->getOppenentFor($player);
        $lead = $player->points - $opponent->points;
        return $lead;
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

    /**
     * Returns the opponent to the player
     *
     * @return Player player
     */
    public function getOppenentFor(Player $player)
    {
        $opponent = $this->players()->where('id', '!=', $player->id);
        return $opponent->first();
    }

    /**
     * Add one point to the player
     *
     * @return void
     */
    public function addPointFor(Player $player)
    {
        $player->addPoint();

        if ($player->points > 10) {
            $opponent = $this->getOppenentFor($player);
            if ($opponent->points >= 10) {
                if ($this->getScoreDifference($player) > 1) {
                    $player->sets_won += 1;
                    $this->startNewSet();
                }        
            } else {
                $player->sets_won += 1;
                $this->startNewSet();
            }
        }
        $player->save();
        return $player;
    }

    /**
     * Reset score and start a new set
     *
     * @return void
     */
    public function startNewSet()
    {
        $this->set += 1;
        $this->save();
        foreach ($this->players()->get() as $player) {
            $player->resetPoints();
        }
    }
    

    public function currentSet()
    {
        return $this->set;
    }
    
    /**
     * Set up the relationship
     */
    public function players()
    {
        return $this->hasMany('App\Player');
    }
    
}
