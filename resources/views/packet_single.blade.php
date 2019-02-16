@extends('layouts.master')

@section('title','Welcome')

@section('content')

<div class="l-page-content">
	<div class="c-left-text">
		<h2>Packet: {{$packet_id}}</h2>
		<p>
			<?php
				if (!$payload_type_name) {
					$payload_type_name = "?";
				}
			?>
			<strong>payload type:</strong> {{$payload_type_name}}<br />
			<strong>last submitted:</strong> {{$last_submitted}}<br />
			<strong>submitted by:</strong> {{$public_submitters}}
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
				<strong>Last update:</strong> {{$sat_status['time']}}
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
				@foreach ($sat_status as $key => $value)
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
			@if ($payload_type_name)
				<?php
				?>
				<p><strong>Payload type:</strong> {{$payload_type_name}}</p>
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
