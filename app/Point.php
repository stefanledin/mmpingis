<?php 

namespace App;

class Point {

	protected $match;
	protected $player;

	public function inMatch($match)
	{
		$this->match = $match;
	}

	public function by($player)
	{
		$this->player = $player;
	}

	public function add()
	{
		$this->match->addPointFor($this->player);
	}

}