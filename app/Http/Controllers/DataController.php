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
    * @param string $data_encoded Base64-encoded binary data from the SDR plugin.
    * @return Array $data Array of decoded values.
    *
    */
    private function parseBinary($data_encoded) {
      //feed the hash to the C++ parser
      //

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

        $binary = new SubmissionBinary([
          'data'=> $data_encoded,
          'submission_id'=>$submission->id,
        ]);
        $binary->save();

        return response('Upload failed, checksum incorrect.',400);
      }

      $status_seq_id = $data['status']['sequence_id'];
      $secondary_seq_id = $data['payload']['sequence_id'];

      switch ($data['payload_type']) {
        case Packet::P_CONFIG_CODE:
          $secondary_seq_column = Packet::P_CONFIG_SEQ_COLUMN;
          $secondary_table_column = Packet::P_CONFIG_TBL_COLUMN;
          $sat_secondary = new SatConfig();
          # code...
          break;
        case Packet::P_GPS_CODE:
          $secondary_seq_column = Packet::P_GPS_SEQ_COLUMN;
          $secondary_table_column = Packet::P_GPS_TBL_COLUMN;
          $sat_secondary = new SatGPS();
          # code...
          break;
        case Packet::P_HEALTH_CODE:
          $secondary_seq_column = Packet::P_HEALTH_SEQ_COLUMN;
          $secondary_table_column = Packet::P_HEALTH_TBL_COLUMN;
          $sat_secondary = new SatHealth();
          # code...
          break;
        case Packet::P_IMG_CODE:
          $secondary_seq_column = Packet::P_IMG_SEQ_COLUMN;
          $secondary_table_column = Packet::P_IMG_TBL_COLUMN;
          $sat_secondary = new SatIMG();
          # code...
          break;
        case Packet::P_IMU_CODE:
          $secondary_seq_column = Packet::P_IMU_SEQ_COLUMN;
          $secondary_table_column = Packet::P_IMU_TBL_COLUMN;
          $sat_secondary = new SatIMU();
          # code...
          break;
        default:
          # code...
          break;
      };

      $last_valid = Carbon::now()->subHours(12)->toDateTimeString();
      $packet = Packet::whereDate('last_submitted','<',$last_valid)
        ->where('status_sequence_id',$status_seq_id)
        ->where('payload_type',$data['payload_type'])

        ->where($secondary_seq_column,$secondary_seq_id)
        ->where('checksum',$data['checksum'])
        ->orderBy('last_submitted', 'desc')
        ->first();

      //error_log("payload type: ".$data['payload_type']);
      //error_log("status sequence id: ".$status_seq_id);
      //error_log("secondary column: ".$secondary_seq_column);
      //error_log("secondary column id: ".$secondary_seq_id);
      //should this use FirstOrUpdate instead?
      /*
      $packet = Packet::where('status_sequence_id',$status_seq_id)
        ->where('payload_type',$data['payload_type'])
        ->where($secondary_seq_column,$secondary_seq_id)->orderBy('last_submitted', 'desc')->first();
        */
      $result_message;
      if (!$packet) {
        //create new packet
          //Log::info('NO PACKET!');
          $packet = new Packet([
            'status_sequence_id'=>$status_seq_id,
            $secondary_seq_column=>$secondary_seq_id,
            'last_submitted'=> Carbon::now()->toDateTimeString(),
            'checksum'=>$data['checksum'],
            'hash'=>$data['hash'],
            'payload_type'=>$data['payload_type'],
          ]);
          $packet->save();

          //add packet_id to status data
          $status_data = $data['status'];
          $status_data['packet_id'] = $packet->id;

          //save status data
          $sat_status = new SatStatus($status_data);
          $sat_status->save();

          //add packet_id to secondary data
          $secondary_data = $data['payload'];
          $secondary_data['packet_id'] = $packet->id;

          //save secondary data
          $sat_secondary->update($secondary_data);

          //add table ids to packet
          $packet->status_table_id = $sat_status->id;
          $packet->$secondary_table_column = $sat_secondary->id;
          $packet->save();

          $result_message = "New packet created. ID: ".$packet->id;

      } else {
          //Log::info('Found packet, id: '.$packet->id);
          //packet already in the db, only update timestamp
          $packet->last_submitted = Carbon::now()->toDateTimeString();
          $packet->save();
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
