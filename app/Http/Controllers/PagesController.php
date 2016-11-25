<?php namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;

/**
 * 
 */
class PagesController extends Controller {
	
	public function __construct() {
		//$this->middleware('guest'); //this 'restricts' the page (or, well, all of the refined ones below) only to logged-out users
		//CAUTION:if this is used on a page where the login form redirects after a successful login, it creates a redirect loop!
	}
	
	
	public function home() {
		return view('home');
	}
	
	public function about() {
		return view('about')->with("version",'<strong style="color:red">1</strong>');
	}
	
	public function contribute() {
		return view('contribute');
	}
	
	public function submit() {
		return 'this will be a page about submitting';
	}
}