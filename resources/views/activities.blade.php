@extends('layout')


@section('title')
	<title>Welcome to Movie Vibe</title>
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.2.0/css/font-awesome.min.css" />

	<link rel="stylesheet" type="text/css" href="css/menu.css" />
	<link rel="stylesheet" type="text/css" href="css/sidebar.css" />
	<link rel="stylesheet" type="text/css" href="css/hover.css" />
	<link rel="stylesheet" type="text/css" href="css/favs.css" />
	<script src="js/modernizr.custom.js"></script>
	<script src="js/snap.svg-min.js"></script>

@stop
		

@section('content')

<!-- 
	Welcome {{Auth::user()->username}}!
	Your genre id is {{Auth::user()->genre_id}}.
	<a class="btn btn-1 btn-1f" href="{{url('logout')}}">Logout</a> -->
	<div class="menu-section">
		<nav id="menu" class="menu">
			<button class="menu__handle"><span>Menu</span></button>
			<div class="menu__inner">
				<ul>
					<li><a href="dashboard"><i class="fa fa-fw fa-home"></i><span>Home<span></a></li>
					<li><a href="favorites"><i class="fa fa-fw fa-heart"></i><span>Favs<span></a></li>
					<li><a href="activities"><i class="fa fa-fw fa-comments"></i><span>Activities<span></a></li>
					<li><a href="{{url('logout')}}"><i class="fa fa-fw fa-sign-out"></i><span>Logout<span></a></li>
				</ul>
			</div>
			<div class="morph-shape" data-morph-open="M300-10c0,0,295,164,295,410c0,232-295,410-295,410" data-morph-close="M300-10C300-10,5,154,5,400c0,232,295,410,295,410">
				<svg width="100%" height="100%" viewBox="0 0 600 800" preserveAspectRatio="none">
					<path fill="none" d="M300-10c0,0,0,164,0,410c0,232,0,410,0,410"/>
				</svg>
			</div>
		</nav>
		<div class="main">
			<header class="header">
				<h1>Hey {{Auth::user()->username}}!</h1>
				<h2>Check your friend's favorites!</h2>
			</header>
			<center>
			<div class="favs">
				<table class="table table-striped" id="movies">
					@foreach($movies as $movie)
					<tr>
						<td>{{$movie->user->username}}</td>
						<td><img src="http://image.tmdb.org/t/p/w185{{$movie->poster_link}}"></td>
						<td>{{$movie->title}}</td>
						<td>{{$movie->genre->genre_name}}</td>
						<td>{{$movie->tmdb_id}}</td>
						<td>{{$movie->tmdb_rating}}</td>
						<td>{{$movie->created_at}}</td>
					</tr>
					@endforeach
				</table>
			</div>
			</center>
		</div>
	</div>

	<script type="text/handlebars" id="movie-template">
		<tr>
			<td>@{{user->username}}</td>
			<td><img src="http://image.tmdb.org/t/p/w185@{{poster_link}}"></td>
			<td>@{{title}}</td>
			<td>@{{genre->genre_name}}</td>
			<td>@{{tmdb_id}}</td>
			<td>@{{tmdb_rating}}</td>
			<td>@{{created_at}}</td>
		</tr>
	</script>
@stop


@section('scripts')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://js.pusher.com/2.2/pusher.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.2/handlebars.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<script>
		var movieTemplate = Handlebars.compile($('#movie-template').html());
		var pusher = new Pusher('2ea8a452caee25bb9515');

		var channel = pusher.subscribe('movie_channel');

		channel.bind('newmovie', function(data){
			console.log(data)
			var movie = JSON.parse(data.movie);
			var html = movieTemplate(movie);
			$('#movies tbody').prepend(html);
			toastr.success(movie.title + ' was added!');
		}

	</script>

	<script src="js/classie.js"></script>
	<script src="js/toucheffects.js"></script>

	<script>
			(function() {

				function SVGMenu( el, options ) {
					this.el = el;
					this.init();
				}

				SVGMenu.prototype.init = function() {
					this.trigger = this.el.querySelector( 'button.menu__handle' );
					this.shapeEl = this.el.querySelector( 'div.morph-shape' );

					var s = Snap( this.shapeEl.querySelector( 'svg' ) );
					this.pathEl = s.select( 'path' );
					this.paths = {
						reset : this.pathEl.attr( 'd' ),
						open : this.shapeEl.getAttribute( 'data-morph-open' ),
						close : this.shapeEl.getAttribute( 'data-morph-close' )
					};

					this.isOpen = false;

					this.initEvents();
				};

				SVGMenu.prototype.initEvents = function() {
					this.trigger.addEventListener( 'click', this.toggle.bind(this) );
				};

				SVGMenu.prototype.toggle = function() {
					var self = this;

					if( this.isOpen ) {
						classie.remove( self.el, 'menu--anim' );
						setTimeout( function() { classie.remove( self.el, 'menu--open' );	}, 250 );
					}
					else {
						classie.add( self.el, 'menu--anim' );
						setTimeout( function() { classie.add( self.el, 'menu--open' );	}, 250 );
					}
					this.pathEl.stop().animate( { 'path' : this.isOpen ? this.paths.close : this.paths.open }, 350, mina.easeout, function() {
						self.pathEl.stop().animate( { 'path' : self.paths.reset }, 800, mina.elastic );
					} );
					
					this.isOpen = !this.isOpen;
				};

				new SVGMenu( document.getElementById( 'menu' ) );

			})();
		</script>
@stop
