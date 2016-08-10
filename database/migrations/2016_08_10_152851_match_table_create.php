<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MatchTableCreate extends Migration
{
    public function up()
    {
        Schema::create('match_table', function (Blueprint $table) {
            $table->integer('matchId')->unsigned();
            $table->integer('champion')->unsigned();
            $table->dateTime('timestamp');
            $table->string('lane');
            $table->string('queue');
			$table->integer('player_id')->unsigned();
			 
			$table->foreign('player_id')->references('playerOrTeamId')->on('player_table');
            
            $table->primary(['matchId', 'player_id']);
        });
    }

    public function down()
    {
        Schema::drop('match_table');
    }
}
