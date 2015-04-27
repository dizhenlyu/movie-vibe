<?php

class MovieTest extends TestCase {

	public function testValidateReturnsFalseIfMovieTitleAndGenreIdIsMissing(){
		$validation = \App\Models\Movie::validate([]);
		$this->assertEquals($validation->passes(), false);

	}

	public function testValidateReturnsTrueIfMovieTitleAndGenreIdIsPresent(){
		$validation = \App\Models\Movie::validate([
			'title' => 'Test',
			'genre_id' => '1'
		]);
		$this->assertEquals($validation->passes(), true);
	}

}