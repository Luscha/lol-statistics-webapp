<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;
use App\Player;
use App\Match;

use GuzzleHttp\Client;

use Carbon\Carbon;

class FetchController extends Controller
{
    public function fetchChallengers()
    {
		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', 'https://euw.api.pvp.net/api/lol/euw/v2.5/league/challenger?type=RANKED_SOLO_5x5&api_key=RGAPI-5BDA3E91-E0A6-43B7-9B82-F1DC0CF020AC', ['verify' => false]);
		
		//echo $res->getStatusCode();
		$json = json_decode($res->getBody(), true);
		$count = count($json['entries']);
		
		echo "Fetched ".$count." ".$json['tier']." (Division ".$json['name'].")<br>";
		
		for ($i = 0; $i < $count; $i++) 
		{
			$player = Player::firstOrNew(['playerOrTeamId' => $json['entries'][$i]['playerOrTeamId']]);
			$player->playerOrTeamName =			$json['entries'][$i]['playerOrTeamName'];
			$player->wins =								$json['entries'][$i]['wins'];
			$player->leaguePoints =					$json['entries'][$i]['leaguePoints'];
			$player->tier =									$json['tier'];
			$player->division =							$json['entries'][$i]['division'];
			$player->playerOrTeamId =				$json['entries'][$i]['playerOrTeamId'];
			$player->save();
			
			echo "Saving '".$player->playerOrTeamName."' (".($i + 1)." of ".$count.")<br>";
		} 
	}
	
	public function fetchMasters()
    {
		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', 'https://euw.api.pvp.net/api/lol/euw/v2.5/league/master?type=RANKED_SOLO_5x5&api_key=RGAPI-5BDA3E91-E0A6-43B7-9B82-F1DC0CF020AC', ['verify' => false]);
		
		//echo $res->getStatusCode();
		$json = json_decode($res->getBody(), true);
		$count = count($json['entries']);
		
		echo "Fetched ".$count." ".$json['tier']." (Division ".$json['name'].")<br>";
		
		for ($i = 0; $i < $count; $i++) 
		{
			$player = Player::firstOrNew(['playerOrTeamId' => $json['entries'][$i]['playerOrTeamId']]);
			$player->playerOrTeamName =			$json['entries'][$i]['playerOrTeamName'];
			$player->wins =								$json['entries'][$i]['wins'];
			$player->leaguePoints =					$json['entries'][$i]['leaguePoints'];
			$player->tier =									$json['tier'];
			$player->division =							$json['entries'][$i]['division'];
			$player->playerOrTeamId =				$json['entries'][$i]['playerOrTeamId'];
			$player->save();
			
			echo "Saving '".$player->playerOrTeamName."' (".($i + 1)." of ".$count.")<br>";
		} 
	}
	
	public function fetchMatches()
	{
		$pCount = Player::where('processed', 1)
				->orWhere('last_process', '>', Carbon::now()->subDay())
				->count();
				
		$pCountTotal = Player::count();
				
		$player = Player::where('processed', 0)
				->orWhere('last_process', '<', Carbon::now()->subDay())
				->first();
			   
		if (null == $player || 0 == $pCount)
		{
			$response["status"] = "finished";
			return response()->json($response);
		}
		
		try 
		{
			$client = new \GuzzleHttp\Client();
			$res = $client->request('GET', 'https://euw.api.pvp.net/api/lol/euw/v2.2/matchlist/by-summoner/'.$player->playerOrTeamId.'?rankedQueues=TEAM_BUILDER_DRAFT_RANKED_5x5&seasons=SEASON2016&api_key=RGAPI-5BDA3E91-E0A6-43B7-9B82-F1DC0CF020AC', 
				['verify' => false, 'connect_timeout' => 10]);
		}
		catch (\GuzzleHttp\Exception\ClientException $e) 
		{
			$response["status"] = "wait";
			return response()->json($response);
		}	
		catch (\GuzzleHttp\Exception\ServerException $e) 
		{
			$response["status"] = "wait";
			return response()->json($response);
		}
		
		$json = json_decode($res->getBody(), true);
		$count = count($json['matches']);

		
		for ($i = 0; $i < $count; $i++) 
		{
			$match = Match::firstOrNew(['matchId' => $json['matches'][$i]['matchId'], 'player_id' => $player->playerOrTeamId]);
			$match->matchId =									$json['matches'][$i]['matchId'];
			$match->champion =									$json['matches'][$i]['champion'];
			$match->timestamp =								Carbon::createFromTimestamp($json['matches'][$i]['timestamp'])->toDateTimeString();
			$match->lane =											$json['matches'][$i]['lane'];
			$match->queue =										$json['matches'][$i]['queue'];
			$match->player_id =									$player->playerOrTeamId;
			$match->save();
		} 
		
		$player->processed = 1;
		$player->last_process = Carbon::now();
		$player->save();
		
		$response["status"] = "content";
		$response["mNum"] = $count;
		$response["pName"] = $player->playerOrTeamName;
		$response["pProcessed"] = $pCount+1;
		$response["pTotal"] = $pCountTotal;
		
		return response()->json($response);
	}
}
