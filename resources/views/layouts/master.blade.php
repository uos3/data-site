<!DOCTYPE html>
<html>
    <head>
        <title>UoS³{{ isset($title) ? " -- ".$title : '' }}</title>
        <link rel="stylesheet" href="/css/bootstrap.css">
        <link rel="stylesheet" href="{{ elixir("css/app.css") }}">
	<link href="https://fonts.googleapis.com/css?family=Coda|Raleway:400,400i,700" rel="stylesheet">
	<meta name="robots" content="noindex">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    </head>

    <body class="page-welcome">
    	<header id="main-header" class="container-fluid">
    		<div class="row">
    			<div class="col-md-3 col-sm-3 logo-col">
    				<a href="/">
	    				<h1 class="logo">
		    				<img src="/img/uos3.png">
		    				<div>Data</div>
		    			</h1>
	    			</a>
    			</div>
    			<div class="col-md-7 col-sm-7 menu-col">
					<nav class="pages-menu">
		    			<ul>
		    				<li><a href="/satellite-info">Satellite info</a></li>
		    				<li><a href="/collected-data">Collected data</a></li>
		    				<li><a href="/leaderboard">Leaderboard</a></li>
                <li><a href="http://uos3.space">About UoS<sup>3</sup></a></li>
		    			</ul>
		    		</nav>
				</div>
    			<div class="col-md-2 col-sm-2 menu-col">

    				<nav class="user-menu">
		    			@if (Auth::check())
		    				@if (Auth::user()->name == '')
		    					<a href="/profile" class="profile-link">{{ Auth::user()->email }}</a>
		    				@else
		    					<a href="/profile" class="profile-link">{{ Auth::user()->name }}</a>
		    				@endif
		    				| <a href="/logout" class="logout-link">Log out</a>
		    			@else
		    				<a href="/login" class="login-link">Login</a> | <a href="/register" class="register-link">Register</a>
		    			@endif



		    		</nav>
    			</div>
    		</div>
    	</header>
    	<div id="wrapper">
			@if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
           	@elseif (session('status'))
                <div class="alert alert-info">
                    {{ session('status') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

    		@yield('content')
    </div>
    <footer class="footer">
		    <p>© 2016 UoS³. All Rights Reserved.</p>
		</footer>
    </body>
</html>
