@extends('layouts.master')

@section('title','Welcome')

@section('content')

<div class="l-page-content">
	<div class="c-home-intro c-left-text">
		<strong class="home__intro">Welcome to the UoS<sup>3</sup> data site.</strong>
		<p>
			This site has two goals:
		</p>
			<ul>
				<li>
					Give the general public access to the collected data.
				</li>
				<li>
					Allow volunteer HAM operators to submit data.
				</li>
			</ul>
			<p>
				This is <a href="#">a link</a>.
			</p>
	</div>
	<div class="l-data-pane">
		<div class="c-data-fswitch">
			<a href="" class="js-data-table c-data-fswitch__link  c-data-fswitch__link--active">table</a>
			<a href="" class="js-data-dashboard c-data-fswitch__link">dashboard</a>
		</div>
		@if ($packets->isEmpty())
			<div class="c-data-card">
				Uh oh, no packets found in the database.
			</div>
		@else
		<div class="c-data-card">
			<h2>Last packets</h2>
			<p>
				Last submission time: {{$last_submitted}}
			</p>
			<table class="table">
				<thead>
					<tr>
						<th>
							ID
						</th>
						<th>
							Sat time
						</th>
						<th>
							Payload type
						</th>
						<th>
							Payload
						</th>
					</tr>
				</thead>
				@foreach ($packets as $packet)
					<?php
						$packet->sat_status();
						$payload_name = $packet->getPayloadType();
						if (!$payload_name) {
							$payload_name = "?";
						}
			 		?>
					@if ($packet->sat_status)
						<tr>
							<td>
								{{$packet->id}}
							</td>
							<td>
								{{$packet->sat_status->time}}
							</td>
							<td>
								{{$payload_name}}
							</td>
							<td>
								<a href="{{$packet->getUrl()}}">(show)</a>
							</td>
						</tr>
					@endif
				@endforeach
			</table>
			<p>
				<a href="/packets">see all packets</a>
			</p>
		</div>
		<div class="c-data-card">
			<h2>Sat status</h2>
			<p>
				Last update: {{$last_status_update}}
			</p>
			<table class="table">
				<thead>
					<tr>
						<th>
							Key
						</th>
						<th>
							Value
						</th>
					</tr>
				</thead>
				@foreach ($last_status as $key => $value)
					<tr>
						<td>
							{{$key}}
						</td>
						<td>
							{{$value}}
						</td>
					</tr>
				@endforeach

			</table>

		</div>
	@endif
	</div>


</div>
@endsection
