<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Validator;
use Log;
use Exception;

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
use App\Packet;

class DataController extends Controller
{
    public function __construct() {
    }

    private function validateAppKey($app_key) {
      if ($app_key !== env('APP_KEY',null)) {
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
    * @param string $data_encoded  Base64-encoded binary data from the SDR plugin.
    * @return Array $data Array of decoded values.
    *
    */
    private function parseBinary($data_encoded) {
      if (is_string($data_encoded)===false || base64_decode($str, true) === false)
      {
          throw new Exception("Not a base64 string.", 1);
      }

      $data = [
        'payload_type'=>'a',
        'status'=> [
            'sequence_id'=>2,
            'spacecraft_id'=>'x',
            'spacecraft_time'=>'2018-02-18 21:00:00',
            'time_source'=>'x',
            'not_actually_a_value'=>'x'
        ],
        'payload' => [
            'tx_enable'=>true,
            'sequence_id'=>6,
        ],
        'hash'=>'',
        'checksum'=>'',
      ];
      //$data = false;
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
      if ($app_key =='') {
        return response("No app key supplied.",401);
      }

      if (!$this->validateAppKey($app_key)) {
        return response("App key incorrect.",403);
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

      $downlink_time = $request->input('downlink_time'); //this isn't in the binary

      if ($request->input('data') == '') {
        return response("No data submitted.",400);
      }

      $plain = (bool) $request->input('plain',FALSE);

      if ($plain) {
        try {
            $data = $this->parseBinary($request->input('data'));
        } catch (Exception $e) {
            return response($e->getMessage(),500);
        }
        $data_input = $request->input('data');
      } else {
        $data = $request->input('data');
        $data_input = json_encode($request->input('data'));
      };

      if (!$data) {
        Submission::saveFailed($user_id,$ip,$downlink_time,$data_input);

        return response('Upload failed, checksum incorrect.',400);
      }

      if (!array_key_exists($data['payload_type'],Packet::$payloads)) {
        return response("Invalid payload type.",400);
      }

      $status_seq_id = $data['status']['sequence_id'];
      $payload_seq_id = $data['payload']['sequence_id'];
      $packet = Packet::find($data['payload_type'],$status_seq_id,$payload_seq_id,$data['checksum']);

      $result_message;
      if (!$packet) {
        //create new packet
          //Log::info('NO PACKET!');
          $packet = Packet::create([
            'status_sequence_id'=>$status_seq_id,
            'last_submitted'=> Carbon::now()->toDateTimeString(),
            'checksum'=>$data['checksum'],
            'hash'=>$data['hash'],
            'payload_type'=>$data['payload_type'],
          ]);

          //add packet_id to status data
          $status_data = $data['status'];
          $status_data['packet_id'] = $packet->id;

          //save status data
          $sat_status = SatStatus::create($status_data);
          $packet->status_table_id = $sat_status->id;
          $packet->save();

          $packet->savePayload($data['payload']);

          Submission::saveSuccessful($user_id,$ip,$packet->id,$downlink_time,$data_input);

          $result_message = "New packet created. ID: ".$packet->id;

      } else {
          //Log::info('Found packet, id: '.$packet->id);
          //packet already in the db, only update timestamp
          $packet->last_submitted = Carbon::now()->toDateTimeString();
          $packet->save();
          Submission::saveSuccessful($user_id,$ip,$packet->id,$downlink_time,$data_input );
          $result_message = "Packet already exists. ID: ".$packet->id;
      };


      //if submission is okay, increase user's upload count
      if (isset($data['user_id'])) {
				$user->upload_count = $user->upload_count + 1;
				$user->save();
        $result_message .= " Updated user upload count.";
			};

      return "Success. ".$result_message;
      //Log::info("TEST");

    }

	/**
	 * Redirects to info page if url is accessed with GET verb.
	 */
	public function redirect() {
		return redirect()->route('submit');
	}
}
