<?php

namespace App\Repositories;

use App\Matches;
use App\Venues;
use App\Teams;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

/**
 * Class MatchesRepository.
 */
class MatchesRepository
{
	protected $venues;
	protected $teams;
	protected $matches;

	public function __construct(){
		$this->venues = with(new Venues)->getTable();
		$this->teams = with(new Teams)->getTable();
		$this->matches = with(new Matches)->getTable();
	}

	public function getMatches($teamId=""){
		DB::enableQueryLog();
		$query = Matches::Select("$this->matches.*","$this->venues.name as venue","team1.name as team1","team2.name as team2","winner.name as winner")
				->leftJoin($this->venues,"$this->matches.venue_id","=","$this->venues.id")
				->leftJoin($this->teams." as team1","$this->matches.team_id_1","=","team1.id")
				->leftJoin($this->teams." as team2","$this->matches.team_id_2","=","team2.id")
				->leftJoin($this->teams." as winner","$this->matches.winner_id","=","winner.id");
				if(!empty($teamId)){
					$query->orWhere(function ($query) use($teamId) {
						$query->where('team_id_1', DB::raw($teamId))
						->orWhere('team_id_2', DB::raw($teamId));
					});
				}
		return $result = $query->get()->toArray();
		
		//dd(DB::getQueryLog());
	}
	public function getVenuesAndTeams($data){
		$date  = $data->matchDate;
		$resp['status'] = 0;
		$resp['msg'] = "Some error occured, please contact admin !";
		if(!empty($date))
		{
			$matchDate = Carbon::parse($date)->format('Y-m-d');
			$venuesOptions = "<option value=\"\"> Select </option>";
			$teamsOptions = "<option value=\"\"> Select </option>";
			$venuesQuery =  DB::select("SELECT venues.id,venues.name FROM venues LEFT JOIN matches ON venues.id = matches.venue_id AND matches.match_date = '$matchDate' WHERE matches.id IS NULL ");
			
			if(is_array($venuesQuery) && !empty($venuesQuery)){
				foreach($venuesQuery as $key=>$value){
					$venuesOptions .= "<option value=\"".$value->id."\">".$value->name."</option>";
				}
				
			}
			
			$teamsQuery =  DB::select("SELECT teams.id,teams.name FROM teams LEFT JOIN matches m1 ON teams.id = m1.team_id_1 AND m1.match_date = '$matchDate' LEFT JOIN matches m2 ON teams.id = m2.team_id_2 AND m2.match_date = '$matchDate' WHERE m1.id IS NULL AND m2.id IS NULL ");			
			if(count($teamsQuery) > 1){
				if(is_array($teamsQuery) && !empty($teamsQuery)){
					foreach($teamsQuery as $key=>$value){
						$teamsOptions .= "<option value=\"".$value->id."\">".$value->name."</option>";
					}
				$resp['status'] = 1;
				$resp['msg'] = "";
				$resp['teamsOptions'] = $teamsOptions;
				}
			}else{
				$resp['status'] = 0;
				$resp['msg'] = "Only one team available for $date, please choose another date !";
			}			
			$resp['venuesOptions'] = $venuesOptions;
		} 
		return $resp;
	}
	
	public function saveMatchFixture($data){
		$team_1 = $data->team_1;
		$team_2 = $data->team_2;
		$venue = $data->venue_id;
		$matches = DB::Select("select exists(select id from `matches` where `match_date` = '2020-07-13' and `matches`.`venue_id` = $venue and (`team_id_1` = $team_1 or `team_id_2` = $team_1 or `team_id_1` = $team_2 or `team_id_2` = $team_2)) as `exists` ");
	
		if(@$matches[0]->exists==0){
			return Matches::create([
				'match_date'=>$data->match_date,
				'venue_id'=>$data->venue_id,
				'team_id_1'=>$data->team_1,
				'team_id_2'=>$data->team_2,
				'venue_id'=>$venue,
				'winning_points'=>$data->winning_points,
				'points_to_both'=>$data->points_to_both,
			]);
		}
		return false;
		
	}
	
	public function saveMatchResult($data){
		$resp['status'] = 0;
		$resp['msg'] = "Some error occured, please contact admin !";
		$result = $data->result;
		$winner_id = $data->winner_id;
		$team_1_runs = $data->team_1_runs;
		$team_2_runs = $data->team_2_runs;
		$team_id_1 = $data->team_id_1;
		$team_id_2 = $data->team_id_2;
		$match_id= $data->match_id;
		switch($result){
			case 'Win and loss':
			$post_data = array(
				'result' => $result,
				'winner_id' => $winner_id,
				'team_1_runs' => $team_1_runs,
				'team_2_runs' => $team_2_runs,
			);
			if($team_1_runs==$team_2_runs){
				$resp['msg'] = "Team1 and Team 2 score should be different !";
				return $resp;
			}
			if($winner_id == $team_id_1){
				if($team_1_runs <= $team_2_runs){
					$resp['msg'] = "Team 1 score must be greater than team 2 !";
					return $resp;
				}
			} else {
				if($team_2_runs <= $team_1_runs){
					$resp['msg'] = "Team 2 score must be greater than team 1 !";
					return $resp;
				}
			}
			break;
			case 'Tie':
			$post_data = array(
				'result' => $result,
				'team_1_runs' => $team_1_runs,
				'team_2_runs' => $team_2_runs,
			);
			if($team_1_runs != $team_2_runs){
				$resp['msg'] = "Team 1 and team 2 score must be same !";
				return $resp;
			}
			break;
			default:
			$post_data = array(
				'result' => $result,
			);
			break;
		}		
		if(Matches::where('id','=',$match_id)->exists()){
			$saved = Matches::where('id', $match_id)->update($post_data);			
			$match = Matches::find($match_id);
			$matchResult =  $match->result;
			switch($matchResult){
				case 'Win and loss':
				$winner_id = $match->winner_id;
				$team = Teams::find($winner_id);
				$team->points = $team->points + $match->winning_points;
				$team->save();
				break;
				case 'No Result':
				case 'Tie':
				$team_1_id = $match->team_id_1;
				$team_2_id = $match->team_id_2;
				$team1 = Teams::find($team_1_id);
				$team1->points = $team1->points + $match->points_to_both;
				$team1->save();
				$team2 = Teams::find($team_2_id);
				$team2->points = $team2->points + $match->points_to_both;
				$team2->save();
				break;
			}		
			if($saved){
				$resp['status'] = 1;
				$resp['msg'] = "Match result Updated successfully !";
			}
		}
		return $resp;
	}
}
