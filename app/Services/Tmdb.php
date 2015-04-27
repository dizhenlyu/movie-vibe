<?php namespace App\Services;

use Cache;

class Tmdb{

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
}
?>