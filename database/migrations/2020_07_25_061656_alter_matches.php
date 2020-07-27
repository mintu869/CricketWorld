<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		 Schema::table('matches', function($table) {
			$table->integer('winning_points');
			$table->integer('points_to_both');
			$table->integer('venue_id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		 Schema::table('matches', function($table) {
			$table->dropColumn('winning_points');
			$table->dropColumn('points_to_both');
			$table->dropColumn('venue_id');
		});
    }
}
