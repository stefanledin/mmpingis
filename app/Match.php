<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $fillable = ['set'];

    public function getScore()
    {

    }

    public function players()
    {
        return $this->hasMany('App\Player');
    }
}
