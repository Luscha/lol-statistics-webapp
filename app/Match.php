<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
	protected $fillable = ['champion', 'lane', 'queue'];
	protected $guarded = ['matchId', 'timestamp', 'player_id'];
	
	protected $table = 'match_table';
	protected  $primaryKey = 'matchId';
	public $timestamps = false;
	
	public function get_player()
	{
		return $this->hasOne('App\Player', 'playerOrTeamName', 'player_id');
	}
}
