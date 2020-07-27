<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_history', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('player_id');
			$table->integer('matches');
			$table->integer('runs');
			$table->integer('highest_score');
			$table->integer('fifties');
			$table->integer('hundreds');
			$table->softDeletes('deleted_at', 0);
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
        Schema::dropIfExists('player_history');
    }
}
