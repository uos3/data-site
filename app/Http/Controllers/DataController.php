<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Submission;
use App\User;
use App\Http\Requests;
use Carbon\Carbon;
use Validator;
//use Request;

class DataController extends Controller
{
    public function __construct(Submission $submission) {
    	$this->submission = $submission;
    }
		
    //
    
    public function submit(Request $request) {
    	//if submission's api key isn't correct, abort.
		
		//error_log("says appkey is this: ".$request->app_key);
		//error_log("env appkey is this: ".env('APP_KEY'));
		
		if (!isset($request->app_key)) {
			abort(401, 'No app key supplied.'); //authenticate
		} 
		
		if (env('APP_KEY') != $request->app_key) {
			abort(401, 'Supplied app key "'.$request->app_key.'" is incorrect.'); //REauthenticate
		}
		
		//get submitter's ip
		$ip = $request->ip();
		
		//check if IP isn't blacklisted		
		if ($user->blocked) {
			abort(403, 'Access denied.'); //lolnope.
		}
		
		//is submit_key set? if yes: get user 
		
		//if submit_key wrong, throw error (shouldn't accidentally upload anonymous data if the key is wrong...)
		
		//check if user isn't blocked		
		if ($user->blocked) {
			abort(403, 'Access denied.'); //lolnope.
		}
		
		//build the data array from $request
		$data = $request->all();
		
		//add computed values
		$data['uploaded_at'] = Carbon::now()->toDateTimeString();
		
		$data['ip_address'] = $ip;
		
		//if user is authenticated:
		$data['user_id'] = $user->id; //otherwise keep NULL
		
		//validate
		$validator = Validator::make($data,Submission::$validation_rules);
		
		if ($validator->fails()) {
			$errors = $validator->errors()->all();
			return "Failure. ".implode(' ', $errors)."\n";
		} else {
			$submission = new Submission($data);
			$submission->save();
			return "Success.";
		}
    }
	
	/**
	 * Redirects to info page if url is accessed with GET verb. 
	 */
	public function redirect() {
		return redirect()->route('submit');
	}
}
