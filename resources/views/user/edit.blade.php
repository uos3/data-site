@extends('layouts.master')

@section('title','Welcome')

@section('content')
	
<div class="content">
	
	<div class="row">
		<div class="col-sm-12">
			<h2>Edit profile</h2>		
		</div>
	</div>	
	<div class="row"> 
		<div id="user-data" class="col-md-9 col-sm-12">
			<form id="user-data" method="POST">
				@if (count($errors) > 0)
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				{{ csrf_field() }}
				<div class="form-group">
					<label for="input-name">Name:</label>
					<input type="text" class="form-control" id="input-name" name="name" value="{{$fields['name']}}">
				</div>
				<div class="form-group">
					<label for="input-affiliation">Affiliation (e.g. school, club, etc.):</label>
					<input type="text" class="form-control"  id="input-affiliation" name="affiliation" value="{{$fields['affiliation']}}">
				</div>
				<div class="form-group">
					<label>Show me on the leaderboard: 
					@if ($fields['public'])
						<input type="checkbox" checked="checked" value="1" id="input-public" name="public">
					@else
						<input type="checkbox" value="1" id="input-public" name="public">
					@endif
					</label>	
					
					
				</div>
				<input type="submit" class="btn btn-default" value="Save changes">
			</form>
		</div>			
	</div>
	    		        		
</div>
@endsection
