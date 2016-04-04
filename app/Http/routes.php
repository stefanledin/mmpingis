<?php

use App\Player;
use App\Match;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('start');
});

Route::get('ny-match', 'MatchController@create');
Route::post('ny-match', 'MatchController@store');

Route::get('player/{index}/addpoint', function($index) {
    $match = Match::all()->last();
    $player = $match->players[($index-1)];
    Event::fire(new App\Events\PlayerScoredPoint($player, true));
});
Route::get('match/startnewset', function() {
    $match = Match::all()->last();
    Event::fire(new App\Events\StartNewSet($match));
});

Route::get('match/{id}', 'MatchController@show');
