<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
 protected $fillable = ["team_id_1","team_id_2","match_date","venue_id","winning_points","points_to_both"];
}
