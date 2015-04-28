<?php namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use App\User;
use Illuminate\Http\Request; 
use Auth;

class FavoritesController extends Controller {

	public function getFavorites(){
		
		$user_id = Auth::user()->id;

		//ORM, eager loading
		$favs = Movie::with('genre')->where('user_id', '=', $user_id)->get();

		return view('favorites',[
			'favs' => $favs
		]);

	}

	public function postFavorites(Request $request){

		$movie_id = $request->input('movie_id');
		$movieEntry = Movie::find($movie_id);
		$movieEntry->delete();

		return redirect('favorites');

	}
}
