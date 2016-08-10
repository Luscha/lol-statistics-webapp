<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['playerOrTeamName', 'wins', 'leaguePoints', 'tier', 'division', 'processed', 'last_process'];
	protected $guarded = ['playerOrTeamId',];
	
	protected $table = 'player_table';
	protected  $primaryKey = 'playerOrTeamId';
	public $timestamps = false;
	
	public function get_matches()
	{
		return $this->has_many('App\Match', 'player_id');
	}
}
