@extends('layout')

@section('title')
	<title>Movie Vibe</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/btn.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
@stop

@section('content')
   <header>
        <h1>Movie Vibe <span>by Dizhen Lu</span></h1>
       	<a class="btn btn-1 btn-1f" href="login">Login</a>
		<a class="btn btn-1 btn-1f" href="signup">Sign Up</a>
	</header>

@stop

@section('scripts')
    <!-- BigVideo Dependencies -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-1.8.1.min.js"><\/script>')</script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.imagesloaded.min.js"></script>
    <script src="http://vjs.zencdn.net/c/video.js"></script>

    <!-- BigVideo -->
    <script src="js/bigvideo.js"></script>

    <script>
        $(function() {
            BV = new $.BigVideo();
            BV.init();
            BV.show('vid/movies.mp4',{ambient:true});
        });
    </script>
@stop