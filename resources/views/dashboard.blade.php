@extends('layout')


@section('title')
	<title>Welcome to Movie Vibe</title>
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.2.0/css/font-awesome.min.css" />

	<link rel="stylesheet" type="text/css" href="css/menu.css" />
	<link rel="stylesheet" type="text/css" href="css/sidebar.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrp.min.css" />
	<link rel="stylesheet" type="text/css" href="css/hover.css" />
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
					<li><a href="#"><i class="fa fa-fw fa-folder"></i><span>Files<span></a></li>
					<li><a href="#"><i class="fa fa-fw fa-tachometer"></i><span>Stats<span></a></li>
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
				<h1>Welcome {{Auth::user()->username}}!</h1>
				<h2>Movies from your chosen genre are ready!</h2>
				<h3>Switch your genre to </h3>
				<form method="post" action="changeGenre">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<input type="hidden" name="user_id" value="{{Auth::user()->id}}">

					<div class="form-group">
						<label for="genre_id">Genre: </label>
						<select name="genre_id" class="form-control">
							@foreach($genres as $genre)
									<option value="{{$genre->id}}">
										{{$genre->genre_name}}
									</option>
							@endforeach
						</select>
					</div>
					<input type="submit" value="Submit">
				</form>
			</header>
<!-- 			@foreach($movies as $movie)
				<div class="col-md-4">
					<img src="http://image.tmdb.org/t/p/w342{{$movie->poster_path}}">
				</div>
			@endforeach -->
			<ul class="grid cs-style-3">
				@foreach($movies as $movie)
				<li>
					<figure>
					<img src="http://image.tmdb.org/t/p/w500{{$movie->poster_path}}">
						<figcaption>
							<h3>{{$movie->title}}</h3>
							<span>{{$movie->vote_average}}</span>
							<form method="post">
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="title" value="{{$movie->title}}">
								<input type="hidden" name="tmdb_id" value="{{$movie->id}}">
								<input type="hidden" name="vote" value="{{$movie->vote_average}}">
								<input type="hidden" name="poster" value="{{$movie->poster_path}}">

								<button type="submit" class="add-to-favorite">Add to favorite</button>
							</form>
						</figcaption>
					</figure>
				</li>
				@endforeach
			</ul>
		</div><!-- /main -->
	</div><!-- /container -->

@stop

@section('scripts')
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