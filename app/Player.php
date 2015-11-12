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
    	return $this;
    }

    public function points()
    {
    	return $this;
    }

    public function in(Match $match)
    {
    	
    }
}
