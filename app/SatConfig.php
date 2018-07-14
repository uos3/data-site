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
    'sequence_id',
		'tx_enable',
		'tx_interval_beacon',
		'tx_interval_downlink',
		'tx_datarate',
		'tx_packet_size',
		'tx_power',
		'tx_warning_power',
		'tx_warning_threshold',
		'low_voltage_threshold',
		'low_voltage_recovery_threshold',
		'power_stats_acquisition_interval',
		'configuration_acquisition_interval',
		'imu_acquisition_interval',
		'gps_acquisition_interval',
		'image_acquisition_time',
		'image_acquisition_profile',
		'imu_acquisition_number',
		'greetings_message_transmission_interval',
		'enable_gps_time_sync',
		'imu_bandwidth',
		'gps_sample_count',
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
