@extends('layouts.master')

@section('title','Welcome')

@section('content')

<div class="l-page-content">
	<div class="c-home-intro">
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
	<div class="l-home-data">
		<div class="c-data-fswitch">
			<a href="" class="js-data-table c-data-fswitch__link  c-data-fswitch__link--active">table</a>
			<a href="" class="js-data-dashboard c-data-fswitch__link">dashboard</a>
		</div>
		<div class="c-data-card">
			<h2>Last packets</h2>
			<p>
				Last submission time: {{$packets->first()->last_submitted}}
			</p>
			<table class="table">
				<thead>
					<tr>
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
						$payload_name = $payloads[$packet->payload_type]['name'];
			 		?>
					<tr>
						<td>
							{{$packet->sat_status->spacecraft_time}}
						</td>
						<td>
							{{$payload_name}}
						</td>
						<td>
							<a href="">show packet</a>
						</td>
					</tr>
				@endforeach
			</table>
			<p>
				<a href="">see all packets</a>
			</p>
		</div>
		<div class="c-data-card">
			<h2>Sat status</h2>
			<p>
				<?php
				$last_packet = $packets->first();
				$last_packet->sat_status();
				$last_as_array = $last_packet->toArray();
				$status = $last_as_array['sat_status'];
				?>
				Last update: {{$last_packet->sat_status->downlink_time}}
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
	</div>


</div>
@endsection
