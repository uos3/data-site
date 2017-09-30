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
			<div id="submit-key-block">
				<h3>Submit key</h3>
				<p>This is your submit key. You will need to paste this into the xxx plugin to submit data as this account.</p>
				<p id="submit-key">{{$user->submit_key}}</p>				
			</div>
			
			<dl id="user-data">
				<h3>User Info</h3>
				<p class="user-data__name"><dt>Name:</dt> <dd>{{$user->name}}</dd></p>
				<p class="user-data__affiliation"><dt>Affiliation (e.g. school, club, etc.):</dt> <dd>{{$user->affiliation}}</dd></p>
				<p class="user-data__public"><dt>Display on the leaderboard: </dt>
				@if ($user->public)
					<dd>YES</dd>
				@else
					<dd>NO</dd>
				@endif
				</p>
				<a class="btn btn-default" href="/profile/edit">Edit</a>
			</dl>
		</div>			
	</div>
	    		        		
</div>
@endsection
