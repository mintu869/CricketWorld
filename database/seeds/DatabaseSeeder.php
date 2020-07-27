<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Teams;
use App\Players;


class DatabaseSeeder extends Seeder {

    public function run()
    {
		$this->call('PlayerTableSeeder');
        $this->command->info('Player table seeded!');
    }

}

class TeamTableSeeder extends Seeder {

    public function run()
    {
        Teams::create(array(
            'name' => "Team ".rand(1,10),
            'logo' => "logo_".rand(1,10).".jpg",
            'club' => "Club ".rand(1,10),
        ));
    }

}

class PlayerTableSeeder extends Seeder {

    public function run()
    {
        Players::create(
		array(
            'first_name' => "Player".Str::random(1),
            'last_name' => "Last".Str::random(1),
			'team_id' => 2,
			'jersey_number' =>rand(1,100),
			'country' => "country".rand(1,10)
        ),
		array(
            'first_name' => "Player".Str::random(1),
            'last_name' => "Last".Str::random(1),
			'team_id' => 2,
			'jersey_number' =>rand(1,100),
			'country' => "country".rand(1,10)
        ),
		array(
            'first_name' => "Player".Str::random(1),
            'last_name' => "Last".Str::random(1),
			'team_id' => 2,
			'jersey_number' =>rand(1,100),
			'country' => "country".rand(1,10)
        ),
		array(
            'first_name' => "Player".Str::random(1),
            'last_name' => "Last".Str::random(1),
			'team_id' => 2,
			'jersey_number' =>rand(1,100),
			'country' => "country".rand(1,10)
        ),
		array(
            'first_name' => "Player".Str::random(1),
            'last_name' => "Last".Str::random(1),
			'team_id' => 2,
			'jersey_number' =>rand(1,100),
			'country' => "country".rand(1,10)
        ),
		array(
            'first_name' => "Player".Str::random(1),
            'last_name' => "Last".Str::random(1),
			'team_id' => 2,
			'jersey_number' =>rand(1,100),
			'country' => "country".rand(1,10)
        ),
		array(
            'first_name' => "Player".Str::random(1),
            'last_name' => "Last".Str::random(1),
			'team_id' => 2,
			'jersey_number' =>rand(1,100),
			'country' => "country".rand(1,10)
        ),
		array(
            'first_name' => "Player".Str::random(1),
            'last_name' => "Last".Str::random(1),
			'team_id' => 2,
			'jersey_number' =>rand(1,100),
			'country' => "country".rand(1,10)
        ),
		array(
            'first_name' => "Player".Str::random(1),
            'last_name' => "Last".Str::random(1),
			'team_id' => 2,
			'jersey_number' =>rand(1,100),
			'country' => "country".rand(1,10)
        ),
		array(
            'first_name' => "Player".Str::random(1),
            'last_name' => "Last".Str::random(1),
			'team_id' => 2,
			'jersey_number' =>rand(1,100),
			'country' => "country".rand(1,10)
        ),
		array(
            'first_name' => "Player".Str::random(1),
            'last_name' => "Last".Str::random(1),
			'team_id' => 2,
			'jersey_number' =>rand(1,100),
			'country' => "country".rand(1,10)
        ));
    }

}
