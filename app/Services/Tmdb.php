<?php namespace App\Services;

use Cache;

class Tmdb{

	protected $cache;
	protected $client;

	public function __construct(\Illuminate\Cache\Repository $cache, $client){
		$this->cache = $cache;
		$this->client = $client;
	}

	public static function getMovies($genre_id){

		if(Cache::has("list-$genre_id")){
			$jsonString = Cache::get("list-$genre_id");
		}else{

			$url = "https://api.themoviedb.org/3/genre/$genre_id/movies?api_key=622bab6e82b2dbac7299302ea26abd64";
			$jsonString = file_get_contents($url);
			Cache::put("list-$genre_id", $jsonString, 60);
		}
		
		return json_decode($jsonString)->results;
		
	}

	public function search($genre_id){
		if ($this->cache->has($genre_id)){
			return json_decode($this->cache->get($genre_id));
		}

		$json = $this->client->get('http://api.themoviedb.org/3/genre/' . urlencode($genre_id));
		$this->cache->put($genre_id, $json, 60);
		return json_decode($json);
	}
}
?>