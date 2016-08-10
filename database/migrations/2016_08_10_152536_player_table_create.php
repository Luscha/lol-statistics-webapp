<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlayerTableCreate extends Migration
{
    public function up()
    {
        Schema::create('player_table', function (Blueprint $table) {
            $table->integer('playerOrTeamId')->unsigned();
            $table->string('playerOrTeamName');
            $table->integer('wins')->unsigned();
            $table->integer('leaguePoints')->unsigned();
            $table->string('tier');
            $table->string('division');
            $table->boolean('processed')->default(false);
            $table->dateTime('last_process')->nullable();;
			
			$table->primary('playerOrTeamId');
        });
    }

     public function down()
    {
        Schema::drop('player_table');
    }
}
