<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    public function addPointFor()
    {
    	
    }

    public function getScore()
    {
    	return (object) array(
    		'player1' => 0,
    		'player2' => 0
		);
    }

    public function set()
    {
    	return 1;
    }
}
