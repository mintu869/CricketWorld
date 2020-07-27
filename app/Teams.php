<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
	public function players() {
		return $this->hasMany('App\Players', 'team_id', 'id');
	}
}
