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
			
			<form id="user-data" method="POST">
				<div class="form-group">
					<label for="input-name">Name:</label>
					<input type="text" class="form-control" id="input-name" name="name">
				</div>
				<div class="form-group">
					<label for="input-affiliation">Affiliation (e.g. school, club, etc.):</label>
					<input type="text" class="form-control"  id="input-affiliation" name="affiliation">
				</div>
				<div class="form-group">
					<label>Show me on the leaderboard: <input type="checkbox" id="input-public" name="public"></label>	
				</div>
				<input type="submit" class="btn btn-default" value="Save changes">
			</form>
		</div>			
	</div>
	    		        		
</div>
@endsection
