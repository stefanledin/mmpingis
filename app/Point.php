<?php 

namespace App;

use App\Match;
use App\Player;

class Point {

	protected $match;
	protected $player;

	public function inMatch(Match $match)
	{
		$this->match = $match;
	}

	public function by(Player $player)
	{
		$this->player = $player;
	}

	public function add()
	{
		$this->match->addPointFor($this->player);
	}

}
