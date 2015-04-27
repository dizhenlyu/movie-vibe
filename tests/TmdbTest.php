<?php

class TmdbTest extends TestCase {

	public function testSearchPullFromCache(){

		$json = '{"genre_id": 1, "movies": []}';

		$client = Mockery::mock('App\Services\Client');

		$cache = Mockery::mock('Illuminate\Cache\Repository');
		$cache->shouldReceive('has')->with('1')->andReturn(true);
		$cache->shouldReceive('get')->with('1')->andReturn($json);

		$tdmb = new App\Services\Tmdb($cache, $client);
		$results = $tdmb->search('1');
		$this->assertEquals($results, json_decode($json));
	}

	public function testSearchPullFromApiAndStoreInCache(){
		$client = Mockery::mock('App\Services\Client');
		$client->shouldReceive('get')
		->with('http://api.themoviedb.org/3/genre/2')
		->andReturn('{"genre_id": 2, "movies": []}');

		$cache = Mockery::mock('Illuminate\Cache\Repository');
		$cache->shouldReceive('has')->with('2')->andReturn(false);
		$cache->shouldReceive('put')->with('2', '{"genre_id": 2, "movies": []}', 60)->once();

		$tmdb = new App\Services\Tmdb($cache, $client);
		$results = $tmdb->search('2');
		$this->assertEquals($results, json_decode('{"genre_id": 2, "movies": []}'));
	}
}