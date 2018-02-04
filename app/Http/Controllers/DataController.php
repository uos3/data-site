<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Validator;

/*my Eloquent models*/
use App\Submission;
use App\User;
use App\BlacklistedIP;

class DataController extends Controller
{
    public function __construct() {
    }


    private function validateAccess(Request $request) {

      if (!isset($request->app_key)) {
  			abort(401, 'No app key supplied.'); //authenticate
  		}

  		if (env('APP_KEY') != $request->app_key) {
  			abort(401, 'Supplied app key "'.$request->app_key.'" is incorrect.'); //REauthenticate
  		}

      //get submitter's ip

  		$ip = $request->ip();

  		//check if IP isn't blacklisted
  		if (BlacklistedIP::where("ip_address", "=", $ip)->first() instanceof BlacklistedIP) {
  			abort(403, 'Access denied.'); //lolnope.
  		}

      return TRUE;
    }

    private function getUserIfExists(Request $request) {
      //is submit_key set? if yes: get user
  		if (isset($request->submit_key) && "" != $request->submit_key) {
  			$user = User::where("submit_key","=",$request->submit_key)->first();

  			//if submit_key wrong, throw error (shouldn't accidentally upload anonymous data if the key is wrong...)
  			if (!($user instanceof User)) {
  				abort(401,"No user with this submit key found.");
  			}
        return $user;
  		}

      return FALSE; //no submit key
    }

    private function validateUser($user) {
      if ($user->blocked) {
        abort(403, 'Access denied.'); //lolnope.
      }

      return TRUE;
    };

    public function submit(Request $request) {

      //TODO log submission as string -- special log?
      //Storage::append('file.log', 'Appended Text'); -- https://laravel.com/docs/5.2/filesystem#storing-files

    	//if submission's api key isn't correct, abort.

		//error_log("says appkey is this: ".$request->app_key);
		//error_log("env appkey is this: ".env('APP_KEY'));



    $this->validateAccess($request);

    $user = $this->getUserIfExists();

    if ($user) {
        $this->validateUser($user);
    }


    $data = $request->all();  //possibly only part of data? -- $request->only([a,b,c]), $request->except([a,b,c])

    $this->checksum($data); //TODO CHECKSUM -- throw error???

    //TODO pick which type of upload this is (one-character type number? -- set in .env, no magic numbers!)

    //TODO submit data to sat_status + sat_? depending on type (how do I save all the columns without listing them out, but also without silently ignoring failures?)



    
		//add computed values
		$data['uploaded_at'] = Carbon::now()->toDateTimeString();
		$data['ip_address'] = $ip;

		//if user is authenticated add their id:
		if (isset($user) && ($user instanceof User)) {
			$data['user_id'] = $user->id; //otherwise keep NULL
		}

		//validate
		$validator = Validator::make($data,Submission::$validation_rules);
		if ($validator->fails()) {
			$errors = $validator->errors()->all();
			return "Failure. ".implode(' ', $errors)."\n";
		} else {
			$submission = new Submission($data);
			$submission->save();

			if (isset($data['user_id'])) {
				$user->upload_count = $user->upload_count + 1;
				$user->save();
			};
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
