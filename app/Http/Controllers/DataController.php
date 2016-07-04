<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Submission;
use App\User;
use App\Http\Requests;
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
		
		
		//$user = User::where('ip_address',$ip)->first();
		$user = User::firstOrCreate(['ip_address'=>$ip]); //I think this might stop working once I have more than just ip. Lets figure that out later.
		
		//check if user isn't blocked		
		if ($user->blocked) {
			abort(403); //lolnope.
		}
		
		//gather data
		$data = [];
		
		/**
		$data['cubesat_time'] = $request->cubesat_time; //check if it's... time-y?
		$data['user_id'] = $user->id;
		
		//cubesat data. will change. TODO sanity/validity checks for everything.
		$data['temperature'] = $request->temperature;  
		$data['gyro_x'] = $request->gyro_x;
		$data['gyro_y'] = $request->gyro_y;
		$data['gyro_z'] = $request->gyro_z;
		$data['accelerometer_x'] = $request->accelerometer_x;
		$data['accelerometer_y'] = $request->accelerometer_y;
		$data['accelerometer_z'] = $request->accelerometer_z;
		
		 */
		//$submission = new Submission($data);
		//$submission->save();
		
		return "Success.";
		
		
		
		/**
		 * get ip
check if ip in user db
no: create user, get id
yes: check if user banned
	yes: abort
	no: get user id
		 */


		//check if ip not in banlist
		
		//check if ip in user table
		
		//yes: get user id
		
		//no: create new user AND get id
		
		//get data
		
		//check if valid (numbers, floats, etc.)
		
		//yes: put into db
		
		//no: abort
		
		/*
		 * app sends POST data through specific url
		 * check if the APP KEY is correct (app key is embedded in the Java app)
		 * 
		 * if yes:
		 * 	submit data to db (VALIDATE)
		 * 	return something to notify success (id of submission? date uploaded? ??)
		 * 	if they don't pass validation: return error 
		 * 
		 * if no:
		 * 	return error
		 * 
		 * 
		 */ 
    }
	
	/**
	 * Redirects to info page if url is accessed with GET verb. 
	 */
	public function redirect() {
		return redirect()->route('submit');
	}
}
