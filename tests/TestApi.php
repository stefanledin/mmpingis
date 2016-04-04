<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Player;
use App\Match;

class TestApi extends TestCase
{
    use DatabaseTransactions;

    protected $player1;
    protected $player2;
    protected $match;

    function dummyData()
    {
        $this->player1 = new Player(['nickname' => 'Stefan']);
        $this->player2 = new Player(['nickname' => 'Fredrik']);
        $this->match = Match::create();
        $this->match->players()->saveMany([$this->player1, $this->player2]);
    }
    
    function tearDown()
    {
        Player::truncate();
    }
    

    function test_begin_match()
    {
        $this->visit('/')
            ->click('Ny match')
            ->seePageIs('ny-match')
            ->type('Stefan', 'player1')
            ->type('Fredrik', 'player2')
            ->press('Spela')
            ->seeInDatabase('players', ['nickname' => 'Stefan'])
            ->seeInDatabase('players', ['nickname' => 'Fredrik']);
    }

    function test_first_point()
    {
        $this->dummyData();
        $this->assertEquals(0, Player::find($this->player1->id)->points);
        
        $response = $this->call('GET', '/player/'.$this->player1->id.'/addpoint'); 
        
        $this->assertEquals(200, $response->status());
        $this->assertEquals(1, Player::find($this->player1->id)->points);
    }
    
    function test_new_set()
    {
        $this->dummyData();
        $response = $this->call('GET', '/match/'.$this->match->id.'/startnewset');
        $this->assertEquals(200, $response->status());
        $this->assertEquals(2, Match::find($this->match->id)->currentSet());
    }
    
    
}


