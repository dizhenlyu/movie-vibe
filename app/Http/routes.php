<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\Models\Genre;
use App\Models\Movie;
use App\User;
use App\Services\Tmdb;

Route::get('/', function(){
	return view('index');
});

Route::get('/signup', function(){

	$genres = Genre::all();

	return view('signup', [
		'genres' => $genres
	]);
});

Route::post('/signup', function(){

	$validation = User::validate(Request::all());

	if($validation->passes()){

		$user = new User();

		$user->username = Request::input('username');
		$user->email = Request::input('email');
		$user->password = Hash::make(Request::input('password'));
		$user->genre_id = Request::input('genre_id');
		$user->description = Request::input('description');

		$user->save();


		Auth::loginUsingId($user->id);
		return redirect('dashboard');
	}

	return redirect('signup')
		->withInput()
		->withErrors($validation->errors());

});

Route::get('login', function(){
	return view('login');
});

Route::post('login', function(){

	$credentials = [
		'username' => Request::input('username'), 
		'password' => Request::input('password')
	];

	$remember_me = Request::input('remember_me') == 'on' ? true : false;

	if(Auth::attempt($credentials, $remember_me)){
		return redirect('dashboard');
	}

	return redirect('login');
});

Route::get('/dashboard', ['middleware' => 'auth', function(){

	$genre_id = Auth::user()->genre_id;
	$genre_tmdb_id = Genre::find($genre_id)->genre_tmdb_id;
	$genre_name = Genre::find($genre_id)->genre_name;
	$movies = Tmdb::getMovies($genre_tmdb_id);
	$genres = Genre::all();

	return view('dashboard',[
		'movies' => $movies,
		'genres' => $genres,
		'genre_name' => $genre_name
	]);
}]);

Route::post('/dashboard', ['middleware' => 'auth', function(){

	$movieEntry = new Movie();

	$movieEntry->title = Request::input('title');
	$movieEntry->tmdb_id = Request::input('tmdb_id');
	$movieEntry->tmdb_rating = Request::input('vote');
	$movieEntry->poster_link = Request::input('poster');

	$movieEntry->owned_by_user_id = Auth::user()->id;
	$movieEntry->genre_id = Auth::user()->genre_id;

	$movieEntry->save();

	return redirect('dashboard');
}]);

Route::get('/favorites', ['middleware' => 'auth', function(){

	$user_id = Auth::user()->id;

	//ORM, eager loading
	$favs = Movie::with('genre')->where('owned_by_user_id', '=', $user_id)->get();

	return view('favorites',[
		'favs' => $favs,
	]);

}]);

Route::post('/favorites', ['middleware' => 'auth', function(){

	$movie_id = Request::input('movie_id');
	$movieEntry = Movie::find($movie_id);
	$movieEntry->delete();

	return redirect('favorites');

}]);

Route::post('/changeGenre', ['middleware' => 'auth', function(){

	$user_id = Request::input('user_id');
	$user = User::find($user_id);
	$user->genre_id = Request::input('genre_id');

	$user->save();

	return redirect('dashboard');

}]);

Route::get('logout', function(){

	Auth::logout();

	return redirect('login');
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
