@extends('layout')

@section('title')
	<title>Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
@stop

@section('content')
<div class="container">
	<h1>Login</h1>

	<form method="post">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" id="username" name="username" class="form-control">
		</div>

		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" id="password" name="password" class="form-control">
		</div>

		<div class="checkbox">
			<label for="remember_me">
				<input type="checkbox" id="remember_me" name="remember_me">Remember Me
			</label>
		</div>

		<input type="submit" value="Login" class="btn btn-primary">

	</form>
</div>
@stop