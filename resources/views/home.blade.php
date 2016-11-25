@extends('layouts.master')

@section('title','Welcome')

@section('content')
	
<div class="content container-fluid">
	<div class="row">  
		<div id="project-status" class="card col-md-8 col-sm-12">
			<p class="status-info">The launch date for the satellite has been secured! It will launch on XXth of Somethember 201x.</p>
			<p class="status-post">(learn more in a <a href="">relevant blog post</a>)</p>
		</div>
		<div id="project-intro" class="card col-md-4 col-sm-6">
			<p>Welcome to space. It's a mess.</p>
			<img src="" alt="(some art? illustration????)" />
			<p>Something something, which is why we are doing what we are doing - which is, launching a cube into space.</p>
			<p>(<a href="">learn more</a>)</p>
		</div>
		<div id="share-buttons" class="card col-md-8 col-sm-6">
			<a href=""><img alt="(share on facebook)" /></a>
			<a href=""><img alt="(share on twitter)" /></a>
			<a href=""><img alt="(share on tumblr)" /></a>		
		</div>
	</div>
	<div class="row">
		<div id="news-feed" class="card col-md-4 col-sm-6">
			<h2>News</h2>
			<ul class="news">
				<!-- just titles, or some snippets too? -->
				<li><span class="date">2016-11-12</span>: <a href="">Something Interesting Happened on The Way To Space</a></li>
				<li><span class="date">2016-06-01</span>: <a href="">Poop</a></li>
				<li><span class="date">2016-05-24</span>: <a href="">About This Thing</a></li>
			</ul>
		</div>
		<div id="social-media" class="card col-md-4 col-sm-6">
			<ul class="social-media-links">
				<li><a href="">Our Facebook page</a></li>
				<li><a href="">OUr YouTube channel</a></li>
			</ul>
		</div>
		<div id="newsletter-form" class="card col-md-4 col-sm-12">
			<form>
				Subscribe to our newsletter:
				<input type="text" />
				<input type="button" value="subscribe" />			
			</form>
		</div>
	</div>
	<div class="row">
		<div id="contribution-stats" class="card col-md-4 col-sm-6">
			<p>Last data upload by a contributor: 13:00</p>
			<p>(learn how to <a href="">contribute</a>)</p>
		</div>
		<div id="art" class="card col-md-4 col-sm-6">
			(a bit of art -- ????????)
		</div>
		
		<div id="soton" class="card col-md-4 col-sm-12">University of Southampton (probably logo)</div>
	</div>
	    		        		
</div>
@endsection