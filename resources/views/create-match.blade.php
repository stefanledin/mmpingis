@extends('master')

@section('content')
<div class="row">
    <div class="col s12">
        <form method="post" action="/ny-match">
            {{ csrf_field() }}
            <div class="input-field">
                <input type="text" id="player1" name="player1">
                <label for="player1">Spelare 1</label>
            </div>
            <div class="input-field">
                <input type="text" id="player2" name="player2">
                <label for="player2">Spelare 2</label>
            </div>
            
            <button type="submit" class="btn pink darken-4">Spela <i class="material-icons right">play_circle_filled</i></button>
        </form>
    </div>
</div>
@stop
