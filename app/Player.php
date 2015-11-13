<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Match;

class Player extends Model
{
	public $points;
	protected $chainedMethod;

    public function scored($addPoint)
    {
        $this->chainedMethod = 'scored';
    	return $this;
    }

    public function points()
    {
        $this->chainedMethod = 'points';
    	return $this;
    }

    public function in(Match $match)
    {
        if ($this->chainedMethod == 'points') {
            $score = $match->getScore();
            return $score->player1;
        }
    }
}
