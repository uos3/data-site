<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class SatStatus extends Model
{
	protected $table = 'sat_status';
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */

	/*
  protected $guarded = [
    'timestamp',
  ];
	*/

	protected $fillable = [
		'downlink_time',
		'spacecraft_time',
		'time_source',
		'spacecraft_id',
		'obc_temperature',
		'battery_temperature',
		'battery_voltage',
		'battery_current',
		'charge_current',
		'antenna_deployment',
		'data_pending',
		'reboot_count',
		'rails_status',
		'rx_temperature',
		'tx_temperature',
		'pa_temperature',
		'rx_noisefloor',
		'sequence_id',
		'packet_id',
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

	/**
	 * Laravel Accessor (automatically runs when retrieving data from DB).
	 * @param  String $rails_string Six-character string of "0" and "1".
	 * @return Array               Array of true/false values.
	 */
	public function getRailsStatusAttribute($rails_string) {
		$rails_array = [];

		for ($i = 0; $i<strlen($str); $i++) {
			$rails_array[] = (boolval($str[$i])); //converts "0" to FALSE and "1" to TRUE
		};
		return $rails_array;
	}
	/**
	 * Laravel Mutator (automatically runs when saving into DB).
	 * @param Array $rails_array Array of true/false values.
	 * @return String Six-character string of "0" and "1".
	 */
	public function setRailsStatusAttribute($rails_array) {
		$rails_string = '';
		foreach ($rails_array as $key => $value) {
			$rails_string.= ($value)?"1":"0";
		}
		return $rails_string;
	}
}
