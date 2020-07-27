<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Teams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('teams', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->string('logo', 100);
			$table->string('club', 100);
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
		Schema::dropIfExists('teams');
    }
}
