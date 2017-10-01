@extends('layouts.master')

@section('title','Welcome')

@section('content')
	
<div class="content container-fluid">
	<div class="row">  
		<div id="project-status" class="card col-sm-12">
			<h2>Contributor leaderboard</h2>
				<p>Thanks to everyone submitting data!</p>
				<table id="leaderboard" class="table">
					<thead>
						<tr>
							<th>Position</th>
							<th>User</th>
							<th>Uploads</th>
						</tr>						
					</thead>
					@foreach ($users as $position=>$user)
						<tr>
							<td>{{ $position+1 }}</td>
							<td>{{$user['name']}}
								@if ($user['affiliation'])
									({{$user['affiliation']}})
								@endif
							</td>
							<td>{{$user['upload_count']}}</td>
						</tr>
					@endforeach					
				</table>	
		</div>
	</div>	    		        		
</div>
@endsection
