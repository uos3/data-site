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
use App\Dataset;

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

    private function base64toBinary($input) {
      if (is_string($input)===false)
      {
          throw new Exception("Not a base64 string.", 1);
      }
      $binary = base64_decode($input, true);
      if ($binary === false) {
        throw new Exception("Not a base64 string.", 1);
      }

      return $binary;
    }

    /**
    * Decode uploaded bin file.
    *
    * @param UploadedFile $binary_file Binary file uploaded by user.
    * @return Array $data Array of decoded values.
    *
    */
    private function binaryDecode($binary_file) {
      //TODO the crc and hash should be validated during decoding by the C++ app.

      //TESTING OPTION. This circumvents the telemetry app and serves a dummy JSON output instead.
      if (env('DUMMY_BINFILE_PARSE',false)) {
        $binfile_path = env('DEBUG_DUMMY_JSON_PATH','');
        $telemetry_app_path = env('DEBUG_TELEMETRY_APP_PATH','');
      } else {
        $binfile_path = $binary_file->getRealPath();
        $telemetry_app_path = env('TELEMETRY_APP_PATH','uos3_telemetry_app');
      }
      $command = "$telemetry_app_path parse $binfile_path";

      exec($command,$output_lines_array,$return);
      //throw new Exception(print_r($output_lines_array,true));

      if (!$return === 0) {
        throw new Exception("Telemetry app failed to parse the binary.");
      }

      $json_string = implode($output_lines_array,'');
      $output = json_decode($json_string,true);

      if ($output === NULL) {
        throw new Exception("The telemetry app output is not valid JSON and couldn't be decoded.");
      }

      //TODO Maybe this could be done with Laravel validators?
      if (!array_key_exists('type',$output)) {
        throw new Exception("Decoded JSON doesn't contain expected keys: 'type'.");
      }

      return $output;
      //??? peculiarity of the telemetry app output.
    }

    /**
     * Process and store API submission.
     * @param  Request $request
     * @return String $json JSON success/error message
     */
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

      $format = strtolower($request->input('format','binary'));

      if ($format == 'binary') {
        if (!$request->hasFile('data')) {
          return response("No data submitted.",400);
        }
        if (!$request->file('data')->isValid()) {
          return response("Error on upload.",400);
        }
        if ($request->file('data')->getMimeType() !== 'application/octet-stream') {
          return response("File is not in correct format. Format expected: 'application/octet-stream'. Format received: '".$request->file('data')->getMimeType()."'." ,400);
        }
        $data_binfile = $request->file('data');
        $data_orig_format = file_get_contents($data_binfile->getRealPath());
        //this is the orig binary, to be saved to DB

        try {
          $data = $this->binaryDecode($data_binfile);
        } catch (Exception $e) {
          return response($e->getMessage(),500);
        }

      } else if ($format == 'json' && getenv('APP_DEBUG')) {
        // allow JSON input on dev server for testing purposes.

        if ($request->input('data') == '') {
          return response("No data submitted.",400);
        }
        $data_orig_format = json_encode($request->input('data')); //data was submitted as JSON
        $data = $request->input('data');
      } else {
        return response("Input format not implemented.",400);
      }

      $downlink_time = $request->input('downlink_time');
      //this has been present in previous version of the packet spec; it's now unclear whether it's still used or not
      //if this is not sent, then the db defaults to current timestamp

      //$checksum = $request->input('checksum'); //this was mentioned in the Slack convo. But is it necessary when telemetry app is doing the parsing?

      if (!$data) {
        Submission::saveFailed($user_id,$ip,null,$downlink_time,$data_orig_format);

        return response('Upload failed, checksum incorrect.',400);
      }

      if (!array_key_exists($data['type'],Packet::$payloads)) {
        return response("Invalid payload type.",400);
      }

      if (!$data['crc'] || !$data['hash']) {
        return response("Checksum or hash missing.",400);
      }

      //what do I need?
      //the payload, for saving
      //the beacon_id
      //the dataset_id
      //(and I need to change the db to rename these, ugh)

      $payload_config = Packet::$payloads[$data['type']];

      $payload = $data[$payload_config['json_key']];
      $beacon_id = $data['status']['beacon_id'];
      $dataset_id = $payload['dataset_id'];

      $previously_uploaded_packet = Packet::findPreviouslyUploaded($data['type'],$beacon_id,$dataset_id,$data['crc']);

      $result_message;
      if (!$previously_uploaded_packet) {
        //create new packet
          //Log::info('NO PACKET!');
          $new_packet = Packet::create([
            'beacon_id' => $beacon_id,
            'last_submitted'=> Carbon::now()->toDateTimeString(),
            'crc'=>$data['crc'],
            'hash'=>$data['hash'],
            'type'=>$data['type'],
            'dataset_id'=>$dataset_id,
          ]);


          //add packet_id & downlink_time to status data
          $status_data = $data['status'];
          error_log(print_r($status_data,true));
          $status_data['packet_id'] = $new_packet->id;

          //save status data
          $sat_status = SatStatus::create($status_data);
          $new_packet->status_table_id = $sat_status->id;
          $new_packet->save();

          $new_packet->savePayload($payload);

          Submission::saveSuccessful($user_id,$ip,$new_packet->id,$downlink_time,$data_orig_format);

          $result_message = "New packet created. ID: ".$new_packet->id;

      } else {
          //Log::info('Found packet, id: '.$packet->id);
          //packet already in the db, only update timestamp
          $previously_uploaded_packet->last_submitted = Carbon::now()->toDateTimeString();
          $previously_uploaded_packet->save();
          Submission::saveSuccessful($user_id,$ip,$previously_uploaded_packet->id,$downlink_time,$data_orig_format );
          $result_message = "Packet already exists. ID: ".$previously_uploaded_packet->id;
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

  /**
   * Outputs last packet in a chosen format (more will be added).
   * @param  Request $request
   */
  public function lastPacket(Request $request) {
    $type = $request->get('type',false);
    $format = $request->get('format','json');
    //char
    $packet = Packet::last($type);
    if (!$packet) {
      return response("No packet of this type found.",404);
    }

    try {
      $output = $packet->output($format);
    } catch (Exception $e) {
      return response($e->getMessage(),500);
    }
    return $output;
  }

  public function exportLast(Request $request) {
    //get requested format
    //if format doesn't exist, throw error
    //if JSON:
    //get the last packet of each type
    //combine them into one JSON
    $dataset = new Dataset;
    $format = $request->get('format','json');
    //option to export only the data (i.e. for collecting snapshots over time)

    if (strtolower($format) == 'json') {
      try {
        $output = $dataset->toArray();
        return $output;
      } catch (Exception $e) {
        return response($e->getMessage(),500);
      }
    } else if (strtolower($format) == 'csv') {
      $output = $dataset->toFlatArray();
      $output_string = '';
      $output_string.= implode(array_keys($output),",")."\n";
      $output_string .= implode($output,",");
      return $output_string;
      //provisional - if the content should contain commas/quotes, this would be Very Bad
    } else {
      return response("Output format not implemented.",500);
    }
  }
}
