<?php

/*

TODO MIGRATION!
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class SatConfig extends Model
{
	protected $table = 'sat_config';
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */

  protected $fillable = [
		'packet_id',
		'dataset_id',
		'tx_enable',
		'tx_interval',
		'tx_interval_downlink',
		'tx_datarate',
		'tx_power',
		'tx_overtemp',
		'rx_overtemp',
		'batt_overtemp',
		'obc_overtemp',
		'pa_overtemp',
		'low_voltage_threshold',
		'low_voltage_recovery',
		'health_acquisition_interval',
		'configuration_acquisition_interval',
		'imu_acquisition_interval',
		'imu_sample_count',
		'imu_sample_interval',
		'gps_acquisition_interval',
		'gps_sample_count',
		'gps_sample_interval',
		'image_acquisition_time',
		'image_acquisition_profile',
		'time',
		'operational_mode',
		'self_test',
		'power_rail_1',
		'power_rail_2',
		'power_rail_3',
		'power_rail_4',
		'power_rail_5',
		'power_rail_6',
		'reset_power_rail_1',
		'reset_power_rail_2',
		'reset_power_rail_3',
		'reset_power_rail_4',
		'reset_power_rail_5',
		'reset_power_rail_6',
  ];

	protected $hidden = [
			'packet_id',

	];


	public $timestamps = false; //needed because I'm not using the default timestamp columns (updated_at, created_at), and otherwise php artisan tinker craps itself.

	public static $validation_rules = [];

	public function packet()
	{
		return $this->belongsTo('App\Packet');
	}

}
