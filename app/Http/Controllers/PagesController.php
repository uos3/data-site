<?php namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use App\User;

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
		return view('home');
	}
	
	public function satellite_info() {
		return view('satellite_info');
	}
	
	public function about() {
		return view('about')->with("version",'<strong style="color:red">1</strong>');
	}
	
	public function leaderboard() {
		$public_users = User::where('public',1)->orderBy('upload_count','desc')->get();
		return view('leaderboard')->with("users",$public_users);
	}
	
	public function submit() {
		return 'this will be a page about submitting';
	}
}
