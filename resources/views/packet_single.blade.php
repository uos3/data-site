@extends('layouts.master')

@section('title','Welcome')

@section('content')

<div class="l-page-content">
	<div class="c-left-text">
		<h2>Packet: {{$packet->id}}</h2>
		<p>
			<strong>payload type:</strong> {{$packet->getPayloadType()}}<br />
			<strong>last submitted:</strong> {{$packet->last_submitted}}<br />
			<strong>submitted by:</strong> {{$packet->getPublicSubmitters()}}
		</p>
	</div>
	<div class="l-data-pane">
		<div class="c-data-fswitch">
			<a href="" class="js-data-table c-data-fswitch__link  c-data-fswitch__link--active">table</a>
			<a href="" class="js-data-dashboard c-data-fswitch__link">dashboard</a>
		</div>
		<div class="c-data-card">
			<h2>Sat status</h2>
			<p>
				<?php
				$packet_array = $packet->toArray();
				$status = $packet_array['sat_status'];
				?>
				Last update: {{$packet->sat_status->downlink_time}}
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
				@foreach ($status as $key => $value)
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
		<div class="c-data-card">
			<h2>Payload: {{$packet->getPayloadType()}}</h2>
			<?php
			$payload = $packet->payloadAsArray();
			?>
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
				@foreach ($payload as $key => $value)
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
	</div>


</div>
@endsection
