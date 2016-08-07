<!DOCTYPE html>
<html>
    <head>
        <title>University of Southampton Small Satelite{{ isset($title) ? " -- ".$title : '' }}</title>
        

		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
        <link rel="stylesheet" href="{{ elixir("css/app.css") }}">
    </head>
    <style>
    	body {
    		
    		width:100%;
    	}
    	
    	#wrapper {
    		margin:0 auto;
    		max-width:72em;  
    		padding:0 1em;  		
    	}
    	
    	header {
    		width:100%;
    		margin-top:1em;
    	}
    	
    	header * {
    		
    	}
    	
    	header .logo {
    		margin:0 auto;
    				
    	}
    	.logo > img {
    		width:12em;
    	}
    	
    	.user-area {
    		float:right;
    	}
    	
    	input[type="text"] {
    		background-color:rgba(0,0,0,0.5);
    		border:1px solid black;
    	}
    	
    	a {
    		color:#E72E4F;
    		text-decoration:none;
    	}
    	
    	a:hover, a:active, a:focus {
    		color:rgb(42, 193, 225);    		
    	}
    	
    	a:visited {
    		color:rgb(143, 35, 77);
    		color:rgb(236, 100, 124);
    		color:#AD6370;
    	}
    	
    	nav {
    		margin-top:1em;
    	}
    	
    	nav ul {
    		list-style:none;
    		margin:0;
    		padding:0;
    	}
    	nav ul li {
    		display:inline-block;
    		margin:0;
    		padding:0;
    	}
    	
    	nav ul li a {
    		height:1.5em;
    		padding:0.3em 1em;  
    		border-radius:0.2em;  		
    	}
    	
    	nav ul li a:hover, nav ul li a:active, nav ul li a:focus{
    		background-color:#C02A45;
    		color:#071E24;
    	}
    	#search-form {
    		float:right;    		
    	}
    	
    	.content {
    		padding-top:1.5em;
    	}
    	
    </style>
    <body>
        <div id="wrapper">
        	<header>
        		<div class="user-area">
        			<a href="#" class="login-link">Login | Register</a>
        		</div>        		
        	<h1 class="logo"><img src="/img/uos3-logo-full.png"></h1>
        	<!--
        		<h1>University of Southampton Small Satellite</h1>
        		<p class="tagline">A project to design, manufacture, and fly a CubeSat from the University of Southampton</p>
        	 -->        		
        	</header>
        	<form id="search-form">
        		<input type="text" name="search" placeholder="..." />
        		<a href="#" class="search-btn">Search</a>
        	</form>
        	<nav class="main-nav">
        		<ul>
        			<li>
        				<a href="/">Home</a>
        			</li>
        			<li>
        				<a href="/about">About Us</a>
        			</li>
        			<li>
        				<a href="/satellite">Satellite</a>
        			</li>
        			<li>
        				<a href="/data">Data</a>
        			</li>
        			<li>
        				<a href="/contribute">Contribute</a>
        			</li>
        			<li>
        				<a href="/a-story">*~A Story~*</a>
        			</li>        			        			
        		</ul>
        	</nav>
        	
        	<div class="content">
	        	<div class="intro">
	        		<p>Welcome to space.</p>
	        		<p>It's a mess.</p>
	        		
	        	</div>
	        	@yield('content')        		
        	</div>
        	<footer>
        		
        	</footer>

        	
        	
        </div>
    </body>
</html>
