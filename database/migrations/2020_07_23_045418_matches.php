<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Matches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('matches', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->integer('team_id_1');
			$table->integer('team_id_2');
			$table->integer('team_1_runs')->nullable();
			$table->integer('team_2_runs')->nullable();
			$table->date('match_date');
			$table->integer('winner_id');
			$table->enum('result', ['Win and loss', 'Tie', 'No result','Yet To Be Played'])->default('Yet To Be Played');
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('matches');
    }
}
