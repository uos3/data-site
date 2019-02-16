<?php namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use App\User;
use App\Packet;
use App\SatStatus;
use App\SatHealth;

/**
 *
 */
class PagesController extends Controller {

	public function __construct() {
		//$this->middleware('guest'); //this 'restricts' the page (or, well, all of the refined ones below) only to logged-out users
		//CAUTION:if this is used on a page where the login form redirects after a successful login, it creates a redirect loop!
	}

	public function railsArrayToText($rails_array) {
		$text_array = [];
		foreach($rails_array as $key=>$value) {
			$text_array[] = ($value)?"true":"false";
		}
		return "[".implode($text_array,", ")."]";
	}

	public function unixEpochToTime($timestamp) {
		return date("Y-m-d H:i:s", substr($timestamp, 0, 10));
	}

	public function home() {
		//\Session::flash('status','Noot noot!'); //'flashes' (=shows only once) a notification through the Session ()
		$packets = Packet::orderBy('last_submitted', 'desc')->take(10)->get();
		$last_packet = $packets->first();
		$last_packet->sat_status();

		$values = [
			'packets'=>$packets,
			'last_submitted' => $last_packet->last_submitted,
			'payloads'=>Packet::$payloads,
			'last_status' => $last_packet->sat_status->toArray(),
			'last_status_update' =>$this->unixEpochToTime($last_packet->sat_status->time),
		];

		$values['last_status']['rails_status'] = $this->railsArrayToText($values['last_status']['rails_status']);

		return view('home')->with($values);


	}

	public function satellite_info() {
		return view('satellite_info');
	}

	public function packets() {
		$packets = Packet::orderBy('last_submitted', 'desc')->paginate(50);
		return view('packets')->with([
			'packets'=>$packets,
			'payloads'=>Packet::$payloads,
		]);
	}

	public function packet_single($id) {
		$packet = Packet::with('sat_config','sat_status','sat_health','sat_gps','sat_imu','sat_img')->findOrFail($id);

		$values = [
			'packet_id' => $packet->id,
			'last_submitted' => $packet->last_submitted,
			'public_submitters' => $packet->getPublicSubmitters(),
			'payload_type_name' => $packet->getPayloadType(),
			'sat_status' => $packet->sat_status->toArray(),
			'last_status_update' =>$this->unixEpochToTime($packet->sat_status->time),
			'payload' => $packet->payloadAsArray(),
		];
		$values['sat_status']['rails_status'] = $this->railsArrayToText($values['sat_status']['rails_status']);

		if ($packet->type == Packet::P_HEALTH) {
			$values['payload']['rails_switch_status'] = $this->railsArrayToText($values['payload']['rails_switch_status']);
		$values['payload']['rails_overcurrent_status'] = $this->railsArrayToText($values['payload']['rails_overcurrent_status'] );
		}


		//if not found, error, 404
		//if found, show
		return view('packet_single')->with($values);
	}

	public function about() {
		return view('about')->with("version",'<strong style="color:red">1</strong>');
	}

	public function collected_data() {
		return view('collected_data');
	}

	public function leaderboard() {
		$public_users = User::where('public',1)->orderBy('upload_count','desc')->get();
		return view('leaderboard')->with("users",$public_users);
	}

	public function submit() {
		return 'this will be a page about submitting';
	}
}
