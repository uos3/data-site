<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\SatConfig;
use App\SatGPS;
use App\SatHealth;
use App\SatIMG;
use App\SatStatus;

class Packet extends Model
{
	protected $table = 'packets';
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */

  protected $fillable = [
    'status_table_id',
		'status_sequence_id',
		'health_table_id',
		'health_sequence_id',
		'imu_table_id',
		'imu_sequence_id',
		'img_table_id',
		'img_sequence_id',
		'gps_table_id',
		'gps_sequence_id',
		'config_table_id',
		'config_sequence_id',
		'last_submitted',
		'checksum',
		'hash',
		'payload_type'
  ];

	protected $hidden = [
		'status_table_id',
		'status_sequence_id',
		'health_table_id',
		'health_sequence_id',
		'imu_table_id',
		'imu_sequence_id',
		'img_table_id',
		'img_sequence_id',
		'gps_table_id',
		'gps_sequence_id',
		'config_table_id',
		'config_sequence_id',
	];


	public $timestamps = false; //needed because I'm not using the default timestamp columns (updated_at, created_at), and otherwise php artisan tinker craps itself.

	public static $validation_rules = [];

	public static $endpoint = "/packets/";

	/*
	Packet types from UoS3_TMTC_20180622_v1.2.xlsx
	 */
	const P_CONFIG = '5';
	const P_GPS = '1';
	const P_HEALTH = '3';
	const P_IMG = '4';
	const P_IMU = '2';

	const status_key_column = 'status_sequence_id';

//the keys are WIP, should correspond to the actual chars being used
	public static $payloads = [
		Packet::P_CONFIG=>[
			'seq_column'=>'config_sequence_id',
			'tbl_column'=>'config_table_id',
			'name'=>'sat_config',
			'class'=>'SatConfig',
			'json_key'=>'payload.config'
		],
		Packet::P_GPS=>[
			'seq_column'=>'gps_sequence_id',
			'tbl_column'=>'gps_table_id',
			'name'=>'sat_gps',
			'class'=>'SatGPS',
			'json_key'=>'payload.gps'
		],
		Packet::P_HEALTH=>[
			'seq_column'=>'health_sequence_id',
			'tbl_column'=>'health_table_id',
			'name'=>'sat_health',
			'class'=>'SatHealth',
			'json_key'=>'payload.health'
		],
		Packet::P_IMG=>[
			'seq_column'=>'img_sequence_id',
			'tbl_column'=>'img_table_id',
			'name'=>'sat_img',
			'class'=>'SatIMG',
			'json_key'=>'payload.img'
		],
		Packet::P_IMU=>[
			'seq_column'=>'imu_sequence_id',
			'tbl_column'=>'imu_table_id',
			'name'=>'sat_imu',
			'class'=>'SatIMU',
			'json_key'=>'payload.imu'
		],
	];

	public function submission()
	{
		return $this->hasMany('App\Submission');
	}

	public function sat_config()
	{
		return $this->hasOne('App\SatConfig');
	}

	public function sat_status()
	{
		return $this->hasOne('App\SatStatus');
	}

	public function sat_health()
	{
		return $this->hasOne('App\SatHealth');
	}

	public function sat_gps()
	{
		return $this->hasOne('App\SatGPS');
	}

	public function sat_imu()
	{
		return $this->hasOne('App\SatIMU');
	}

	public function sat_img()
	{
		return $this->hasOne('App\SatIMG');
	}



	public function savePayload($payload) {
		$payload_class = "App\\".Packet::$payloads[$this->payload_type]['class'];
		$payload_model = new $payload_class;

		$payload_model->fill($payload);
		$payload_model->packet_id = $this->id;
		$payload_model->save();

		$payload_tbl_column = Packet::$payloads[$this->payload_type]['tbl_column'];
		$this->$payload_tbl_column = $payload_model->id;
		$payload_seq_column = Packet::$payloads[$this->payload_type]['seq_column'];
		$this->$payload_seq_column = $payload_model->sequence_id;
		$this->save();
	}

	/**
	 * Method that finds whether a specific data packet has been uploaded to the server yet. It uses a combination of parameters to identify it.
	 * @param  Integer $payload_type   Packet::P_CONFIG/...
	 * @param  [type] $beacon_id  [description]
	 * @param  [type] $dataset_id [description]
	 * @param  [type] $checksum       [description]
	 * @return [type]                 [description]
	 */
	public static function findPreviouslyUploaded($payload_type,$beacon_id,$dataset_id,$checksum) {
		$payload_seq_column = Packet::$payloads[$payload_type]['seq_column'];
		// TODO rename this after the DB is updated!
		//
		// we check:
		// time from last upload
		// beacon_id (previously status_sequence_id)
		// payload type
		// dataset_id (previously [payloadtype]_sequence_id)
		// checksum
		//
		$last_valid = Carbon::now()->subHours(12)->toDateTimeString();

		$packet = Packet::whereDate('last_submitted','<',$last_valid)
			->where(Packet::status_key_column,$beacon_id)
			->where('payload_type',$payload_type)
			->where($payload_seq_column,$dataset_id)
			->where('checksum',$checksum)
			->orderBy('last_submitted', 'desc')
			->first();

		return $packet;
	}
/**
 * Get last submitted packet.
 * @param String $type Get packet with payload of a certain type.
 * @return Packet|null The last packet, or null if no packets.
 */
	public static function last($type=false) {
		if (!$type) {
			$packet =  Packet::with('sat_config','sat_status','sat_health','sat_gps','sat_imu','sat_img')
			->orderBy('last_submitted', 'desc')
			->first();
		} else {
			$packet =  Packet::with('sat_config','sat_status','sat_health','sat_gps','sat_imu','sat_img')
			->where('payload_type',$type)
			->orderBy('last_submitted', 'desc')
			->first();
		}

		return $packet;
	}

	public function getData() {
		$this->sat_status();
		$payload_name = Packet::$payloads[$this->payload_type]['name'];
		$this->$payload_name();
	}

	public function getUrl() {
		return Packet::$endpoint.$this->id;
	}

	public function getPayloadType() {
		return Packet::$payloads[$this->payload_type]['class'];
	}

	public function payloadAsArray() {
		$payload_type_name = Packet::$payloads[$this->payload_type]['name'];
		return $this->$payload_type_name->toArray();
	}

	//TODO get public submitters and return as array
	public function getPublicSubmitters() {
		//go through submissions
		//find submissions of this packet with a user ID
		//see if user is public
		//return an array of public users

		$this->submission();
		error_log($this);
		return "";
	}

	public function output($format) {
		if (strtolower($format) == 'json') {
			return $this->toJson();
    } else if(strtolower($format) == 'csv') {
			return $this->toCsv();
		}
		 else {
			throw new Exception("Output format not implemented.");
    }
	}

	public function toCsv() {
		$output_array = $this->toArray();
		$payload_type_name = Packet::$payloads[$this->payload_type]['name'];
		$sat_status = $output_array['sat_status'];
		unset($output_array['sat_status']);
		foreach($sat_status as $key=>$value) {
			$output_array["sat_status.".$key]=$value;
		}
		$payload = $output_array[$payload_type_name];
		unset($output_array[$payload_type_name]);
		foreach($payload as $key=>$value) {
			$output_array[$payload_type_name.".".$key]=$value;
		}
		$output_string = "";
		$output_string.= implode(array_keys($output_array),",")."\n";
		$output_string .= implode($output_array,",");
		return $output_string;
	}

}
