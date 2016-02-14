<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Match;

class Player extends Model
{
    protected $fillable = ['match_id', 'points_set1', 'points_set2', 'points_set3'];
 
    public function scored()
    {
        $match = $this->match()->first();
        $pointsInSet = $this['points_set'.$match->set];
        $this['points_set'.$match->set] = $pointsInSet+1;
        $this->save();
    }

    public function points()
    {
        $match = $this->match()->first();
        return $this['points_set'.$match->set];
    }

    public function match()
    {
        return $this->belongsTo('App\Match');
    }

}
