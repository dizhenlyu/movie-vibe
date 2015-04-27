<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Movie extends Model{
	public function user(){
		return $this->belongsTo('App\Models\User');
	}
	public function genre(){
		return $this->belongsTo('App\Models\Genre');
	}

	public static function validate($input){
		return Validator::make($input, [
			'title' => 'required',
			'genre_id' => 'required|numeric'
		]);
	}
}


?>