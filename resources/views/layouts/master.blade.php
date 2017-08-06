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
    			<div class="col-md-2 col-sm-8 logo-col">
    				<a href="/">
	    				<h1 class="logo">
		    				<img src="/img/uos3-logo-only_bright.png">
		    				<span>Data</span>
		    			</h1>
	    			</a>
    			</div>
    			<div class="col-md-10 col-sm-4 menu-col">
    				<nav class="pages-menu">
		    			<ul>
		    				<li><a href="/satellite-info">Satellite info</a></li>
		    				<li><a href="/satellite-info">Stats</a></li>
		    				<li><a href="/satellite-info">Leaderboard</a></li>
		    			</ul>
		    		</nav>
    				<nav class="user-menu">
		    			@if (Auth::check())
		    				<a href="/profile" class="profile-link">{{ Auth::user()->name }}</a> | <a href="/logout" class="logout-link">Log out</a>
		    			@else
		    				<a href="/login" class="login-link">Login</a> | <a href="/register" class="register-link">Register</a>
		    			@endif
		    		</nav>
    			</div>
    		</div>	
    	</header>
    	<div id="wrapper">
			@if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        
    		@yield('content')   
        	<div class="push"></div>     	
        </div>
        <footer>
		<p>© 2016 UoS³. All Rights Reserved.</p>
		</footer>
    </body>
</html>
