<?php namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use App\User;
use App\Packet;

/**
 *
 */
class PagesController extends Controller {

	public function __construct() {
		//$this->middleware('guest'); //this 'restricts' the page (or, well, all of the refined ones below) only to logged-out users
		//CAUTION:if this is used on a page where the login form redirects after a successful login, it creates a redirect loop!
	}


	public function home() {
		//\Session::flash('status','Noot noot!'); //'flashes' (=shows only once) a notification through the Session ()
		$packets = Packet::orderBy('id', 'desc')->take(10)->get();
		return view('home')->with([
			'packets'=>$packets,
			'payloads'=>Packet::$payloads,
		]);
	}

	public function satellite_info() {
		return view('satellite_info');
	}

	public function packets() {
		$packets = Packet::orderBy('id', 'desc')->paginate(50);
		return view('packets')->with([
			'packets'=>$packets,
			'payloads'=>Packet::$payloads,
		]);
	}

	public function packet_single($id) {
		$packet = Packet::with('sat_config','sat_status','sat_health','sat_gps','sat_imu','sat_img')->findOrFail($id);

		//if not found, error, 404
		//if found, show
		return view('packet_single')->with([
			'packet'=>$packet,
			'payloads'=>Packet::$payloads,
		]);
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
