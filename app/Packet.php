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

	public static $payloads = [
		'a'=>[
			'seq_column'=>'config_sequence_id',
			'tbl_column'=>'config_table_id',
			'name'=>'sat_config',
			'class'=>'SatConfig',
		],
		'b'=>[
			'seq_column'=>'gps_sequence_id',
			'tbl_column'=>'gps_table_id',
			'name'=>'sat_gps',
			'class'=>'SatGPS',
		],
		'c'=>[
			'seq_column'=>'health_sequence_id',
			'tbl_column'=>'health_table_id',
			'name'=>'sat_health',
			'class'=>'SatHealth',
		],
		'd'=>[
			'seq_column'=>'img_sequence_id',
			'tbl_column'=>'img_table_id',
			'name'=>'sat_img',
			'class'=>'SatIMG',
		],
		'e'=>[
			'seq_column'=>'imu_sequence_id',
			'tbl_column'=>'imu_table_id',
			'name'=>'sat_imu',
			'class'=>'SatIMU',
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

	public static function find($payload_type,$status_seq_id,$payload_seq_id,$checksum) {
		$payload_seq_column = Packet::$payloads[$payload_type]['seq_column'];
		$last_valid = Carbon::now()->subHours(12)->toDateTimeString();
		$packet = Packet::whereDate('last_submitted','<',$last_valid)
			->where('status_sequence_id',$status_seq_id)
			->where('payload_type',$payload_type)
			->where($payload_seq_column,$payload_seq_id)
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
	public static function last($type) {
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
	
	public function output($format) {
		if ($format == 'json') {
			return $this->toJson();
    } else {
			throw new Exception("Output format not implemented.");
    }
	}

}
