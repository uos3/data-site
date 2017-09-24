@extends('layouts.master')

@section('title','Welcome')

@section('content')
	
<div class="content">
	
	<div class="row">
		<div class="col-sm-12">
			<h2>User Profile</h2>		
		</div>
	</div>	
	<div class="row"> 
		<div id="user-data" class="col-md-9 col-sm-12">
			<dl class="submit-key">
				<dt>Submit key:</dt>
				<dd>{{$user->submit_key}}</dd>
			</dl>
			<dl>
					<dt>Name:</dt>
					<dd>
						{{$user->name}}&nbsp;				  
					</dd>
					<dt>Affiliation (e.g. school, club, etc.):</dt>
					<dd>
						{{$user->affiliation}}&nbsp;
					</dd>
					<dt>Leaderboard position:</dt>
					<dd>
						@if ($user->public)
		    				{{$leaderboard_position}}&nbsp;	
		    			@else
		    				(set profile to 'public' to show up on the leaderboard)
		    			@endif
						
					</dd>
			</dl>
			<a href="">edit profile</a>
		</div>			
	</div>
	    		        		
</div>
@endsection