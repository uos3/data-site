@extends('layouts.master')

@section('title','Welcome')

@section('content')

<div class="content container-fluid">
	<div class="row">
		<div id="project-status" class="col-md-4 col-sm-12">
			Hi, I am a placeholder. This page will:
			<ul>
				<li>Have some line about wtf it is (submit data here, yada yada).</li>
				<li>Link to pages:
					<ul>
						<li>Satellite info (needed to connect).</li>
						<li>All data. (also link to download csv)</li>
						<li>leader board</li>
						<li>Data as graphs.</li>
						<li>profile</li>
					</ul>
					</li>
			</ul>
		</div>
		<div class="col-md-8 col-sm-12">
			<div id="status-graph-box">
				(status graphs will go here)
			</div>
		</div>
	</div>
</div>
@endsection
