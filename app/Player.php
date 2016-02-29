<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Match;

class Player extends Model
{
    protected $fillable = ['match_id', 'nickname'];
 
    public function addPoint()
    {
        
    }

    public function points()
    {
        return 0;
    }

    public function match()
    {
        return $this->belongsTo('App\Match');
    }

}
