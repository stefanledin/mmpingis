<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Match;

class Player extends Model
{
    protected $fillable = ['points', 'sets_won','match_id', 'nickname'];

    /**
     * Add point
     *
     * @return void
     */
    public function addPoint()
    {
        $this->points += 1;
        $this->save();
    }

    /**
     * Reset points to 0
     *
     * @return void
     */
    public function resetPoints()
    {
        $this->points = 0;
        $this->save();
    }
    
    
 
    public function match()
    {
        return $this->belongsTo('App\Match');
    }

}
