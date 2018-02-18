<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Validator;
use Log;

/*my Eloquent models*/
use App\Submission;
use App\SubmissionBinary;
use App\User;
use App\SatConfig;
use App\SatGPS;
use App\SatHealth;
use App\SatIMG;
use App\SatStatus;
use App\BlacklistedIP;

class DataController extends Controller
{
    public function __construct() {
    }

    private function validateAppKey($app_key) {
      if ($app_key == '') {
          return false;
  		}
      else {
        return true;
      }
    }

    private function validateIP($ip) {
      if (BlacklistedIP::where("ip_address", "=", $ip)->first() instanceof BlacklistedIP) {
  			return false; //lolnope.
  		}
      else {
        return true;
      }
    }

    private function validateAccess(Request $request) {
      //error_log("says appkey is this: ".$request->app_key);
  		//error_log("env appkey is this: ".env('APP_KEY'));

      $app_key = $request->input('app_key');
      if ($app_key == '') {

  			abort(401, 'No app key supplied.'); //authenticate
  		}

  		if (env('APP_KEY') != $app_key) {
  			abort(401, 'Supplied app key "'.$app_key.'" is incorrect.'); //REauthenticate
  		}

      //get submitter's ip

  		$ip = $request->ip();

  		//check if IP isn't blacklisted
  		if (BlacklistedIP::where("ip_address", "=", $ip)->first() instanceof BlacklistedIP) {
  			abort(403, 'Access denied.'); //lolnope.
  		}

      return TRUE;
    }



    private function getUserIfExists($submit_key) {
      $user = User::where("submit_key","=",$submit_key)->first();

      //if submit_key wrong, throw error (shouldn't accidentally upload anonymous data if the key is wrong...)
      if (!($user instanceof User)) {
        return false;
        //abort(401,"No user with this submit key found.");
      } else {
        return $user;
      }
    }

    private function validateUser($user) {
      if ($user->blocked) {
        abort(403, 'Access denied.'); //lolnope.
      };

      return TRUE;
    }

    /**
    * STUB. Convert binary data to php array/object.
    *
    * @param string $data_encoded Base64-encoded binary data from the SDR plugin.
    * @return Array $data Array of decoded values.
    *
    */
    private function parseBinary($data_encoded) {
      //feed the hash to the C++ parser
      //

      //STUB
      $data = [
        'hash'=>'',
        'checksum'=>'',
      ];
      $data = false;
      /*

      //use a Validator to validate all the values. Maybe several validator for the data parts, build them elsewhere, and reuse them???
      $validator = Validator::make($data,[
        'hash'=>'required'
      ]);

      if ($validator->fails()) {
        return "things went bad";
      }
      */

      //maybe instead: validate the fields inside the C++ parser, so I don't have to bother here?
      //...why am I even validating? if the hash and CRC matches, the values MUST be correct, right?

      return $data;
    }

    public function submit(Request $request) {

      $app_key = $request->input('app_key');
      if (!$this->validateAppKey($app_key)) {
        return response("No app key supplied.",401);
      }

      $ip = $request->ip();
      if (!$this->validateIP($ip)) {
        return response("Access denied.",403);
      }

      $submit_key = $request->input('submit_key');
      if ($submit_key != '') {
        $user = $this->getUserIfExists($submit_key);
        if ($user === false) {
          return response("No user with this submit key found. Wrong submit key?",401);
        }

        if (!$this->validateUser($user)) {
          return response("Access denied.",403);
        }
        $user_id = $user->id;
      } else {
        $user_id = null;
      }

      $data_encoded = $request->input("data");
      $data = $this->parseBinary($data_encoded);

      if (!$data) {
        $submission = new Submission([
          'server_time'=> Carbon::now()->toDateTimeString(),
          'user_id'=> $user_id,
          'ip_address'=>$ip,
          'packet_id'=>null,
          'checksum_success'=>false,
        ]);
        $submission->save();

        return response('Upload failed, checksum incorrect.',400);
      }

      

      //save status

      //get packet type

      //save secondary table


      return "Fake success.";


    //Log::info("TEST");



    //TODO pick which type of upload this is (one-character type number? -- set in .env, no magic numbers!)

    //TODO submit data to sat_status + sat_? depending on type (how do I save all the columns without listing them out, but also without silently ignoring failures?)

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
