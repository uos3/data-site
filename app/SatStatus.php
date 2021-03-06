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

	protected $fillable = [
		'packet_id',
		'beacon_id',
		'spacecraft_id',
		'time',
		'time_source',
		'obc_temperature',
		'battery_temperature',
		'battery_voltage',
		'battery_current',
		'antenna_deployment',
		'operational_mode',
		'data_pending',
		'reboot_count',
		'rails_status',
		'rx_temperature',
		'tx_temperature',
		'pa_temperature',
		'rx_noisefloor',
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

	public function railsStringToArray($rails_string) {
		$rails_array = [];

		for ($i = 0; $i<strlen($rails_string); $i++) {
			$rails_array[] = (boolval($rails_string[$i])); //converts "0" to FALSE and "1" to TRUE
		};
		return $rails_array;
	}

	public function railsArrayToString($rails_array) {
		$rails_string = '';
		foreach ($rails_array as $key => $value) {
			$rails_string.= ($value)?"1":"0";
		}
		return $rails_string;
	}

	/**
	 * Laravel Accessor (automatically runs when retrieving data from DB).
	 * @param  String $rails_string Six-character string of "0" and "1".
	 * @return Array               Array of true/false values.
	 */
	public function getRailsStatusAttribute($rails_string) {
		return $this->railsStringToArray($rails_string);
	}
	/**
	 * Laravel Mutator (automatically runs when saving into DB).
	 * @param Array $rails_array Array of true/false values.
	 * @return String Six-character string of "0" and "1".
	 */
	public function setRailsStatusAttribute($rails_array) {
		$this->attributes['rails_status'] = $this->railsArrayToString($rails_array);
	}


}
