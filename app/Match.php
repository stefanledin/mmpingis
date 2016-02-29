<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
            $score[$player->nickname] =  $player->points();
        }
        return (object) $score;
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
