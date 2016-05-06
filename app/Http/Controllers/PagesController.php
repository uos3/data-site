<?php namespace App\Http\Controllers;

/**
 * 
 */
class PagesController extends Controller {
	
	public function __construct() {
		$this->middleware('guest');
	}
	
	
	public function welcome() {
		return 'welcome page';
	}
	
	public function about() {
		return view('about')->with("version",'<strong style="color:red">1</strong>');
	}
	
	public function submit() {
		return 'this will be a page about submitting';
	}
}