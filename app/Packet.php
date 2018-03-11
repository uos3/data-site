<?php

/*

TODO MIGRATION!
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

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

	public $timestamps = false; //needed because I'm not using the default timestamp columns (updated_at, created_at), and otherwise php artisan tinker craps itself.

	public static $validation_rules = [];

	const CONFIG_CODE = 'a';
	const CONFIG_SEQ_COLUMN = 'config_sequence_id';
	const CONFIG_TBL_COLUMN = 'config_table_id';
	const GPS_CODE = 'b';
	const GPS_SEQ_COLUMN = 'gps_sequence_id';
	const GPS_TBL_COLUMN = 'gps_table_id';
	const HEALTH_CODE = 'c';
	const HEALTH_SEQ_COLUMN = 'health_sequence_id';
	const HEALTH_TBL_COLUMN = 'health_table_id';
	const IMG_CODE = 'd';
	const IMG_SEQ_COLUMN = 'img_sequence_id';
	const IMG_TBL_COLUMN = 'img_table_id';
	const IMU_CODE = 'e';
	const IMU_SEQ_COLUMN = 'imu_sequence_id';
	const IMU_TBL_COLUMN = 'imu_table_id';

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
}
