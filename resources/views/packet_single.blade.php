@extends('layouts.master')

@section('title','Welcome')

@section('content')

<div class="l-page-content">
	<div class="c-left-text">
		<h2>Packet: {{$packet->id}}</h2>
		<p>
			<?php
				$payload_name = $packet->getPayloadType();
				if (!$payload_name) {
					$payload_name = "?";
				}
			?>
			<strong>payload type:</strong> {{$payload_name}}<br />
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
				$status['rails_status'] = implode($status['rails_status'],",");
				?>
				<strong>Last update:</strong> {{$packet->sat_status->time}}
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
			<h2>Payload</h2>
			@if ($packet->getPayloadType())
				<?php
				$payload = $packet->payloadAsArray();
				?>
				<p><strong>Payload type:</strong> {{$packet->getPayloadType()}}</p>
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
			@else
				<div class="error">
					This packet is malformed - no payload found.
				</div>
			@endif



		</div>
	</div>


</div>
@endsection
