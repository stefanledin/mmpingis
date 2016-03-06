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
        foreach ($this->players as $player) {
            $score[$player->nickname] =  $player->points;
        }
        return (object) $score;
    }

    public function addPointFor(Player $player)
    {
        if ($player->points < 10) {
            $player->points += 1;
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
