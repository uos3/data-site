<!DOCTYPE html>
<html>
    <head>
        <title>University of Southampton Small Satelite{{ isset($title) ? " -- ".$title : '' }}</title>
        <link rel="stylesheet" href="{{ elixir("css/app.css") }}">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Raleway|Roboto+Condensed" rel="stylesheet"> <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Raleway|Roboto+Condensed" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Anaheim|Carrois+Gothic" rel="stylesheet">     
		<meta name="robots" content="noindex">
        
    </head>
    <style>
    	html {
			box-sizing:border-box;
			height: 100%;
			padding:0;
			margin:0;    	   
		}
		
		div, p {
			padding:0;
			margin:0;
		}
		
		html *, html *:before, html *:after {
			box-sizing:inherit;
		}
		
		img, video{
			max-width:100%;
		}
		
		body {
			margin: 0;
			padding: 0;
			width: 100%;
			height:100%;
			position:relative;	
			
			font-family: 'Carrois Gothic', sans-serif;
			/*font-family: 'Anaheim', sans-serif;*/
			

    /*font-family: 'Roboto Condensed', sans-serif;*/
		}
		
		html, button, input, select, textarea {
		    /* Set your content font stack here: */
		    font-family: 'Carrois Gothic', sans-serif;
			/*font-family: 'Anaheim', sans-serif;*/
		}
		
		/***** VARIABLES *****/
		
		
		
		/***** LAYOUT *****/
		
		

		header {
			width:100%;
			margin-top:1em;
			margin-bottom:3em;
			padding:0 1em;			
		}
				
		header .logo {
			margin:0 auto;
					
		}
		.logo > img {
			width:12em;
		}
		
		.user-area {
			width:100%;
			clear: both;
			height: 2em;
			padding: 0 1em;
			/*background-color:#1B343E;*/
			font-size:1em;
			color:#0378A0;
			
		}
		
		.user-menu {
			float:right;
			height:2em;
			line-height:2em;
		}
		
		.user-menu a, .user-menu a:visited {
			color:#0378A0;
		}
		
		.user-menu a:hover, .user-menu a:focus {
			color:rgb(42, 193, 225);
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
		
		.nav-row {
			margin-bottom:1em;
		}
		
		nav { 		
		}
		
		/*TODO fix the mobile layout! :[ 
		 -- show just selected (3? 4?) links, hide everything else under those.
		 * */
		
		.main-nav {
			text-align:center;
			margin-bottom:1em;
		}
		
		@media only screen and (min-width : 992px) {
			.main-nav {
				text-align:left;
				margin-bottom:0;
				padding-left:0;
				margin-left:0;
			}
	
	    }
		
		nav ul {
			list-style:none;
			margin:0;
			padding:0;
		}
		nav ul li {
			margin:0;
			padding:0;
			display:inline-block;
		}
		
		nav ul li .button.selected {
			color:#0378A0;
		}
		
		input[type="text"] {
			background-color: transparent;
			line-height: 1.5em;
			border: medium none;
			padding: 0.3em;
			border-radius: 0.3em;
			color: #0378A0;
			border: 1px solid #073e4d;
			margin-bottom:1em;	
			text-align:left;		
		}
		
		input[type="text"]:hover, input[type="text"]:focus, input[type="text"]:active {
			border-color:#0378A0;
		}
		
		#search-form {
			line-height:1.5em;	
			text-align:center;					  		
		}
		
		@media only screen and (min-width : 992px) {
			#search-form {
				text-align:right;
			}
	    }
		
		
		footer {
			height:5em;
			font-size:0.8em;
			padding:1em;
			position:absolute;
			bottom:0;
			display:block;
			width:100%;
			color:#0378A0;
		}
	    
	    .button, input[type="button"] {
	    	display:inline-block;
	    	border-radius:0.2em;
			line-height:1.7em;
			padding: 0.2em 1em;
			border: 1px solid transparent;	
			background-color:transparent;		
	    }
	    
	    .button:hover, .button:active, .button:focus, input[type="button"]{
			/*background-color: rgba(192, 42, 69, 0.27);*/
			color:#E72E4F;
			border: 1px solid #E72E4F !important;
			text-decoration: none;
		}
		
		.button:visited {
			color:#E72E4F;
		}
    	
    	
    /*	@media less than x:
     * 
     * search-form should go on its own line
     * menu should have less items: About, Data, Contribute
     * 
     * */
    	
    	.content {
    		line-height:1.4em;
    		
    	}
    	
    	.content.flat {
    		background-color:#0E222A;
    		border-radius:0.4em;
    	}
    	
    	.content p {
    		margin-bottom:1em;
    	}
    	
    	.content p.shout {
    		text-align:center;
    		font-size:3em;
    		color:#E72E4F;
    		margin-top:3em;
    		font-weight:bold;
    	}
    	
    	.card {
    		border:1px solid white;
    	}
    </style>
    <body>
        <div id="wrapper">
        	<div class="user-area">
        			<nav class="user-menu"><a href="#" class="login-link">Login</a> | <a href="#" class="register-link">Register</a></nav>
        	</div>
        	<header>
        		        		
        	<a href="/"><h1 class="logo"><img src="/img/uos3-logo-full_bright.png"></h1></a>
        	<!--
        		<h1>University of Southampton Small Satellite</h1>
        		<p class="tagline">A project to design, manufacture, and fly a CubeSat from the University of Southampton</p>
        	 -->        		
        	</header>
        	<div class="row nav-row">
	        	<nav class="main-nav col-md-8">
	        		<ul>
	        			<li>
	        				<a class="button" href="/">Home</a>
	        			</li>
	        			<li>
	        				<a class="button selected" href="/about">About Us</a>
	        			</li>
	        			<li>
	        				<a class="button" href="/satellite">Satellite</a>
	        			</li>
	        			<li>
	        				<a class="button" href="/data">Data</a>
	        			</li>
	        			<li>
	        				<a class="button" href="/contribute">Contribute</a>
	        			</li>
	        			<li>
	        				<a class="button" href="/a-story">*~A Story~*</a>
	        			</li>        			        			
	        		</ul>
	        	</nav>
	        	
	        	<form id="search-form" class="col-md-4 col-md-offset-0">
	        		<input type="text" name="search" placeholder="..." />
	        		<a href="#" class="search-btn button">Search</a>
	        	</form>
        	</div>
        	@yield('content')
        	<footer>
        	<p>© 2016 UoS³. All Rights Reserved.</p>
        	</footer>
        </div>
    </body>
</html>
