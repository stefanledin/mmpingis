<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Player;
use Event;

class Match extends Model
{
    protected $fillable = ['set', 'won_by'];

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
    public function getScoreDifference(Player $player, Player $opponent)
    {
        return $player->points - $opponent->points;
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
            if ($this->playerWonSet($player)) {
                Event::fire(new Events\PlayerWonSet($player));
                if ($this->playerWonMatch($player)) {
                    Event::fire(new Events\PlayerWonMatch($player));
                }
            }
        }
    }

    /**
     * Checks if the player won the set
     *
     * @return bool
     */
    protected function playerWonSet(Player $player)
    {
        $opponent = $this->getOppenentFor($player);
        if ($opponent->points >= 10) {
            if ($this->getScoreDifference($player, $opponent) > 1) {
                return true;
            }        
        } else {
            return true;
        }
        return false;
    }
    
    /**
     * Checks if the player won the match
     *
     * @return bool
     */
    protected function playerWonMatch(Player $player)
    {
        $sets_won = Player::find($player->id)->sets_won;
        if ($sets_won == 2) {
            return true;
        }
        return false;
    }
    

    /**
     * Reset score and start a new set
     *
     * @return void
     */
    public function startNewSet()
    {
        $this->set = $this->currentSet();
        $this->set += 1;
        $this->save();
    }
    
    /**
     * Reset the score
     *
     * @return void
     */
    public function resetPlayerPoints()
    {
        foreach ($this->players()->get() as $player) {
            $player->resetPoints();
        }
    }
    

    public function currentSet()
    {
        if (!$this->set) {
            return 1;
        }
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
