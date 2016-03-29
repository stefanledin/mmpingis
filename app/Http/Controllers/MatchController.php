<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Player;
use App\Match;

class MatchController extends Controller
{
    /**
     * Skapa och starta en ny match
     */
    public function create()
    {
        return view('create-match');
    }

    /**
     * Spara i DB
     */
    public function store(Request $request)
    {
        $player1 = new Player(['nickname' => $request->input('player1')]);
        $player2 = new Player(['nickname' => $request->input('player2')]);
        $match = Match::create();
        $match->players()->saveMany([$player1, $player2]);
        return redirect('match/'.$match->id);
    }
    
    /**
     * Singel match
     */
    public function show($id)
    {
        $match = Match::find($id);
        return view('match', [
            'match' => $match,
            'players' => $match->players
        ]);
    }
    
    
}
