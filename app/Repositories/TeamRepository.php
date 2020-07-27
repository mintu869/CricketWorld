<?php

namespace App\Repositories;

use App\Teams;

/**
 * Class TeamRepository.
 */
class TeamRepository
{
	/**
	 * @return string
	 *  Return the model
	 */
	public function getTeams()
	{
		return Teams::with('players.history')->get();
		
	}
}
