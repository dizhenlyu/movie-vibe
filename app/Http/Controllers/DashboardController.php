<?php namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use App\User;
use App\Services\Tmdb;
use Illuminate\Http\Request; 
use Pusher;
use Auth;

class DashboardController extends Controller {

	public function getDashboard(){
		$genre_id = Auth::user()->genre_id;
		$genre_tmdb_id = Genre::find($genre_id)->genre_tmdb_id;
		$genre_name = Genre::find($genre_id)->genre_name;
		$movies = Tmdb::getMovies($genre_tmdb_id);
		$genres = Genre::all();

		if($movies){
			return view('dashboard',[
				'movies' => $movies,
				'genres' => $genres,
				'genre_name' => $genre_name
			]);
		}else{
			return view('dashboard',[
				'movies' => Tmdb::getMovies('28'),
				'genres' => $genres,
				'genre_name' => $genre_name
			]);			
		}
	}

	public function postDashboard(Request $request){
		$movieEntry = new Movie();

		$movieEntry->title = $request->input('title');
		$movieEntry->tmdb_id = $request->input('tmdb_id');
		$movieEntry->tmdb_rating = $request->input('vote');
		$movieEntry->poster_link = $request->input('poster');

		$movieEntry->user_id = Auth::user()->id;
		$movieEntry->genre_id = Auth::user()->genre_id;

		$movieEntry->save();

		$app_key = '2ea8a452caee25bb9515';
		$app_id = '117496';
		$app_secret = '3855052ac2be948888f5';

		$movieEntry->username = User::find(Auth::user()->id)->username;
		$movieEntry->genre_name = Genre::find(Auth::user()->genre_id)->genre_name;

		$pusher = new Pusher($app_key, $app_secret, $app_id);
		$pusher->trigger('movie_channel', 'newmovie',[
			'movie' => $movieEntry->toJson()
		]);

		return redirect('dashboard');
	}

	public function changeGenre(Request $request){
		$user_id = $request->input('user_id');
		$user = User::find($user_id);
		$user->genre_id = $request->input('genre_id');

		$user->save();

		return redirect('dashboard');
	}
}
