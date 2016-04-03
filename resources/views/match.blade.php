@extends('master')

@section('content')
<div class="row">
    <div class="col s12">
        <h3 class="center-align">Set: <span id="match-set">{{ $match->currentSet() }}</span></h3>
    </div>
</div>
<div class="row">
    @foreach($players as $player)
        <div id="player{{ $player->id }}" class="col s6">
            <div class="card grey lighten-5">
                <div class="card-content">
                    <p class="center-align"><span class="card-title">{{ $player->nickname }}</span></p>
                    <h1 class="center-align"><span class="player-points">{{ $player->points }}</span></h1>
                    <p class="center-align">Vunna set: <span class="player-sets-won">{{ $player->sets_won }}</span></p>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.5/socket.io.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.20/vue.min.js"></script>
<script>
    var socket = io('http://192.168.10.10:3000');

    socket.on('mmpingis:App\\Events\\PlayerScoredPoint', function(data) {
        var playerDiv = document.getElementById('player'+data.player.id);
        playerDiv.querySelector('span.player-points').innerHTML = (data.player.points + 1);
    });
    socket.on('mmpingis:App\\Events\\PlayerWonSet', function(data) {
        var playerDiv = document.getElementById('player'+data.player.id);
        playerDiv.querySelector('span.player-sets-won').innerHTML = (data.player.sets_won + 1);
    });
    socket.on('mmpingis:App\\Events\\StartNewSet', function(data) {
        document.getElementById('match-set').innerHTML = (data.match.set + 1);
        [].forEach.call(document.querySelectorAll('span.player-points'), function(points) {
           points.innerHTML = 0;
        });
    });
    socket.on('mmpingis:App\\Events\\PlayerWonMatch', function(data) {
        console.log(data);
    });
</script>
@stop
