<?php

namespace App\Console\Commands;

use Redis;
use Illuminate\Console\Command;
use \App\Events\PlayerScoredPoint;

class mmpingis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mmpingis {player} {scoredPoint}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = json_encode([
            'event' => 'PlayerScoredPoint',
            'data' => [
                'player' => $this->argument('player'),
                'addPoint' => (bool) $this->argument('scoredPoint')
            ]
        ]);
        event(new PlayerScoredPoint($this->argument('player'), $this->argument('scoredPoint')));
    }
}
