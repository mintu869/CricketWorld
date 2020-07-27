<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
	public function history() {
		return $this->hasOne('App\PlayerHistory', 'player_id', 'id');
	}
}
