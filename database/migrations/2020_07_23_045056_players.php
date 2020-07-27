<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Players extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('players', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->integer('team_id');
			$table->string('first_name');
			$table->string('last_name');
			$table->integer('jersey_number');
			$table->char('country',50);
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
		Schema::dropIfExists('players');
    }
}
