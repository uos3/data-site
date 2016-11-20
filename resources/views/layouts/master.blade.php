<!DOCTYPE html>
<html>
    <head>
        <title>UoS³{{ isset($title) ? " -- ".$title : '' }}</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="{{ elixir("css/app.css") }}">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Raleway|Roboto+Condensed" rel="stylesheet"> <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Raleway|Roboto+Condensed" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Anaheim|Carrois+Gothic" rel="stylesheet">     
		<meta name="robots" content="noindex">
        
    </head>
    
    <body class="page-welcome">
    	<div class="user-area">
    			<nav class="user-menu">
	    			@if (Auth::check())
	    				<a href="/profile" class="profile-link">{{ Auth::user()->name }}</a> | <a href="/logout" class="logout-link">Log out</a>
	    			@else
	    				<a href="/login" class="login-link">Login</a> | <a href="/register" class="register-link">Register</a>
	    			@endif
	    		</nav>
        			
        </div>
    	<div id="wrapper">
        	<header class="row">
        		<nav class="main-nav col-sm-7">
	        		<ul class="primary-ul">
	        			<li class="logo">
	        				<h1 class="logo"><img src="/img/uos3-logo-only_bright.png"></h1>
	        			</li>
	        			<li>
	        				<a class="selected" href="/about" id="menu-team">About</a>
	        			</li>
	        			<li>
	        				<a href="/satellite" id="menu-satellite">Satellite</a>
	        			</li>
	        			<li>
	        				<a href="/data" id="menu-data">Data</a>
	        			</li>		        			
	        		</ul>
	        		<ul class="secondary-ul">
	        			<li>
	        				<a href="/contribute"  id="menu-contribute">Contribute</a>
	        			</li>
	        			<li>
	        				<a href="/a-story"  id="menu-art">Art</a>
	        			</li>  
						<li>
							<a href="" id="menu-search">Search</a>
						</li>
	        		</ul>
	        	</nav>
	        	<form id="search-form" class="col-sm-5 col-sm-offset-0">
	        		<input type="text" name="search-text" id="search-text" placeholder="..." />
	        		<a href="#" class="search-btn button">Search</a>
	        	</form>
	        </header>
        	@yield('content')   
        	<div class="push"></div>     	
        </div>
        <footer>
		<p>© 2016 UoS³. All Rights Reserved.</p>
		</footer>
    </body>
</html>
