<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Match;

class Player extends Model
{
    protected $fillable = ['points', 'match_id', 'nickname'];
 
    public function match()
    {
        return $this->belongsTo('App\Match');
    }

}
