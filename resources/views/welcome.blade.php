<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link rel="stylesheet" type="text/css" href="css/app.css">
    </head>
    <body>
        
        <div id="player1">
            <h2 class="score">Spelare 1: @{{ score}}</h2>
        </div>
        <div id="player2">
            <h2 class="score">Spelare 2: @{{ score }}</h2>
        </div>

        <script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.4/vue.min.js"></script>
        <script type="text/javascript">
            var socket = io('http://192.168.10.10:3000');

            var players = {
                player1: new Vue({
                    el: '#player1',
                    data: {
                        score: 0
                    }
                }),
                player2: new Vue({
                    el: '#player2',
                    data: {
                        score: 0
                    }
                }),
            };


            socket.on('mmpingis:App\\Events\\PlayerScoredPoint', function (data) {
                var player = data.player;
                if (data.addPoint === 'true') {
                    players[player].score += 1;
                } else {
                    players[player].score -= 1;
                }
            });
        </script>
    </body>
</html>
