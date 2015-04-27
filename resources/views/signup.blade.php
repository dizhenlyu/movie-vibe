@extends('layout')

@section('title')
	<title>Sign Up</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
@stop

@section('content')
<div class="container">
	<h1>Sign Up</h1>

	@foreach($errors->all() as $error)
		<p class="text-danger"> {{ $error }} </p>
	@endforeach
		
	@if (Session::has('success'))
		<p class="text-success"> {{ Session::get('success') }}</p>
	@endif

	<form method="post">
		<input type="hidden" name="_token" value="{{csrf_token()}}">

		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" id="username" name="username" class="form-control" value="{{Request::old('username')}}">
		</div>
		<div class="form-group">
			<label for="email">Email</label>
			<input type="email" id="email" name="email" class="form-control" value="{{Request::old('email')}}">
		</div>

		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" id="password" name="password" class="form-control">
		</div>

		<div class="form-group">
			<label for="password_confirmation">Confirm Password</label>
			<input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
		</div>

		<div class="form-group">
			<label for="genre_id">Genre: </label>
			<select name="genre_id" class="form-control">
				@foreach($genres as $genre)
					@if ($genre->id == Request::old('genre_id'))
						<option value="{{$genre->id}}" selected>
							{{$genre->genre_name}}
						</option>
					@else
						<option value="{{$genre->id}}">
							{{$genre->genre_name}}
						</option>
					@endif
				@endforeach
			</select>
		</div>

		<div class="form-group">
			<label for="description">Description:</label>
			<textarea name="description" class="form-control">{{Request::old('description')}}</textarea>
		</div>

		<input type="submit" value="Sign Up" class="btn btn-primary">

	</form>
</div>
@stop