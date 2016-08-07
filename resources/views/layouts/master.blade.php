<!DOCTYPE html>
<html>
    <head>
        <title>University of Southampton Small Satelite{{ isset($title) ? " -- ".$title : '' }}</title>
        

		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
        <link rel="stylesheet" href="{{ elixir("css/app.css") }}">
    </head>
    <style>
    html {
    	padding:0;
    	margin:0;
    	height:100%;
    }
    	body {
    		padding:0;
    		margin:0;
    		width:100%;
    		height:100%;
    	}
    	
    	#wrapper {
    		position:relative;
    		margin:0 auto;
    		max-width:72em;  
    		padding:0 1em; 
    		min-height: 100%;    				
    	}
    	.content {
			padding-bottom:4.5em;
			
		  }
    	
    	header {
    		width:100%;
    		margin-top:1em;
    		margin-bottom:1em;
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
    	a:visited {
    		color:rgb(143, 35, 77);
    		color:rgb(236, 100, 124);
    		color:#AD6370;
    	}
    	
    	a:hover, a:active, a:focus {
    		color:rgb(42, 193, 225);    		
    	}  	
    	
    	
    	nav {   
    		line-height:2em;
    		 		
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
    		background-color: rgba(192, 42, 69, 0.27);
    		color:#E72E4F;
    	}
    	#search-form {
    		float:right;  
    		line-height:1.5em;
    		padding:0.3em 0em 0.3em 1em;  		
    	}
    	
    	footer {
    		height:4.5em;
    		font-size:0.8em;
    		border-top:1px solid #007B91;
    		padding:1em 0;
    		position:absolute;
    		bottom:1px;
    	}
    	
    	
    	
    /*	@media less than x:
     * 
     * search-form should go on its own line
     * menu should have less items: About, Data, Contribute
     * 
     * */
    	
    	.content {
    		padding-top:1.5em;
    	}
    	
    </style>
    <body>
        <div id="wrapper">
        	<header>
        		<div class="user-area">
        			<a href="#" class="login-link">Login</a> | <a href="#" class="register-link">Register</a>
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
        	<p>© 2016 UoS³. All Rights Reserved.</p>
        	</footer>

        	
        	
        </div>
    </body>
</html>
