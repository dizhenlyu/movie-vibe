<?php namespace App\Http\Controllers;

use App\Models\Movie;
use App\User;
use Illuminate\Http\Request; 
use Auth;

class ActivitiesController extends Controller {

	public function getActivities(){

		$movies = Movie::with('user')->get();

		return view('activities', [
			'movies' => $movies
		]);

	}

}