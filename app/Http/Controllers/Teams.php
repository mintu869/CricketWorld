<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TeamRepository;

class Teams extends Controller
{
	protected $team;
	public function __construct(TeamRepository $team){
		$this->team = $team;
	}
    public function index(){
		$teams = $this->team->getTeams();
		return view('teams',array('teams'=>$teams));
	}

}
