<!DOCTYPE html>
<html>
    <head>
        <title>University of Southampton Small Satelite{{ isset($title) ? " -- ".$title : '' }}</title>
        

		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Raleway|Roboto+Condensed" rel="stylesheet"> <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Raleway|Roboto+Condensed" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Anaheim|Carrois+Gothic" rel="stylesheet">     
        
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
		
		/***** VARIABLES *****/
		
		
		
		/***** LAYOUT *****/
		
		body {
		  color:#cadfe7;
		}
		
		html { 
		  background: url(/img/from_blue_watercolor_wide_1920x1080.png) #041216 no-repeat center center fixed; 
		  -webkit-background-size: cover;
		  -moz-background-size: cover;
		  -o-background-size: cover;
		  background-size: cover;		  
		}
	    #wrapper {
			position:relative;
			margin:0 auto;
			max-width:72em;  
			padding: 0 0 5em 0; /* child elements with margins bleed out of the parent elements. ahahahaha. */
			min-height: 100%;
			
		}

		.content {
			padding:0 1em 5em 1em;
		}
		
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
		
		
		nav { 		
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
		
		.main-nav {
			margin: 0 1em;
			float:left;
			margin-bottom:1em;
			
		}
		
		#search-form input[type="text"] {
			background-color: transparent;
			line-height: 1.5em;
			border: medium none;
			padding: 0.3em;
			border-radius: 0.3em;
			color: #0378A0;
			border: 1px solid #073e4d;
			margin-bottom:1em;
			
		}
		
		#search-form input[type="text"]:hover, #search-form input[type="text"]:focus, #search-form input[type="text"]:active {
			border-color:#0378A0;
		}
		
		#search-form {
			float:right;  
			line-height:1.5em;	
			margin-right:1em;		  		
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
	    
	    .button {
	    	display:inline-block;
	    	border-radius:0.2em;
			line-height:1.7em;
			padding: 0.2em 1em;
			border: 1px solid transparent;			
	    }
	    
	    .button:hover, .button:active, .button:focus{
			/*background-color: rgba(192, 42, 69, 0.27);*/
			color:#E72E4F;
			border: 1px solid #E72E4F !important;
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
    		clear:both;
    		background-color:#0E222A;
    		margin:1em;
    		padding:1em 2em;
    		line-height:1.4em;
    		border-radius:0.4em;
    	}
    	
    	.content p {
    		margin-bottom:1em;
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
        	
        	<nav class="main-nav">
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
        	
        	<form id="search-form">
        		<input type="text" name="search" placeholder="..." />
        		<a href="#" class="search-btn button">Search</a>
        	</form>
        	
        	<div class="content">
	        	<div class="intro">
	        		
<h2 class="title">Mission</h2>
<ul class="page-menu">
	<li><a href="">The team</a></li>
	<li><a href="">Our mission</a></li>
	<li><a href="">Project</a></li>
</ul>
	    <p>UoS­<sup>3</sup> is a project of the University of Southampton to design, build and fly a CubeSat.&nbsp; Also known as the <em>University of Southampton Small Satellite</em>, UoS<sup>3</sup> is a 10x10x10 cm spacecraft that will allow the University to expand its research while giving students practical experience in spacecraft design and development.</p>
		<p>The University of Southampton has been involved in space debris research for over 20 years and UoS<sup>3</sup> is planning to support that interest.&nbsp; The satellite will collect precise orbit and attitude data as its orbit decay under the influence of atmospheric drag, which will be used to validate re-entry prediction tools.</p>
		<p>The project is under the Astronautics Research Group in the University and is overseen by Dr Adrian Tatnall with help from Aleksander Lidtke and Clemens Rumpf, both PhD students.&nbsp; In addition to this two Masters level Group Design Projects – one from the Faculty of Engineering and Environment (FEE) and one from the School of Electronics and Computer Science (ECS) – comprising of a total of 15 students are working on the design of the spacecraft.&nbsp; The Southampton University Space Flight Society (SUSF) are also involved, designing, building and maintaining the University of Southampton Ground Station.</p>
		<p>In 2012-13 the University ran Project Blast, a high-altitude balloon launch of a CubeSat that utilised Android phone technology.&nbsp; Building on this experience we are now in the process of designing and constructing test pieces to verify of design.&nbsp; This stage will last until spring 2015 after which we hope to be in a position to continue with fabrication of the flight hardware. &nbsp;This is being done, aiming for a launch in 2017/18.</p>
		<p>To ensure our satellite complies with current space debris mitigation guidelines which limit a satellites duration in space to 25 years, the satellite must be launched into an orbit of altitude less than 600 km.&nbsp; To meet this condition we would like to launch UoS<sup>3</sup> from the International Space Station by NanoRacks.&nbsp; We currently do not have funds for this launch.&nbsp; If you would like to support our project visit our <em>Support Us</em> section.&nbsp; Or, if you are an amateur radio operator and would like to be involved as a ground-station for UoS<sup>3</sup> please visit our <em>Get Involved</em> section.</p>
	        	</div>
	        	@yield('content')        		
        	</div>
        	<footer>
        	<p>© 2016 UoS³. All Rights Reserved.</p>
        	</footer>
        </div>
    </body>
</html>
