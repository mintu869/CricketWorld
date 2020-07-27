<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\MatchesRepository;
use App\MyConstants;
use Redirect;

class Matches extends Controller
{
	protected $match;
	public function __construct(){
		$this->match = new MatchesRepository();
	}
	
	public function index($team_id=""){
		$matches = $this->match->getMatches($team_id);
		$results = MyConstants::RESULTS;
		return view('matches',array('matches'=>$matches,'results'=>$results));
	}
	
	public function getVenuesAndTeams(Request $request){
		$results = $this->match->getVenuesAndTeams($request);
		return Response()->json($results);
	}
	public function saveMatchFixture(Request $request){
		$resp['status'] = 0;
		$resp['msg'] = "Some error occured, please contact admin !";
		$results = $this->match->saveMatchFixture($request);
		if($results){
			$resp['status'] = 1;
			$resp['msg'] = "Match fixture added successfully !";
		}
		return Response()->json($resp);
	}
	public function saveMatchResult(Request $request){
		$results = $this->match->saveMatchResult($request);		
		return Response()->json($results);
	}
}
