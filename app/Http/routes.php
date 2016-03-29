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

Route::get('match/{id}', 'MatchController@show');

Route::get('player/{id}/addpoint', function($id) {
    $player = Player::find($id);
    Event::fire(new App\Events\PlayerScoredPoint($player, true));
});
Route::get('match/{id}/startnewset', function($id) {
    $match = Match::find($id);
    Event::fire(new App\Events\StartNewSet($match));
});
