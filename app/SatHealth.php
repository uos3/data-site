<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class SatHealth extends Model
{
	protected $table = 'sat_health';
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */

  protected $fillable = [
		'sequence_id',
		'timestamp',
		'obc_temperature',
		'rx_temperature',
		'tx_temperature',
		'pa_temperature',
		'reboot_count',
		'data_packets_pending',
		'antenna_switch',
		'rx_noisefloor',
		'detected_flash_errors',
		'detected_ram_errors',
		'battery_temperature',
		'battery_voltage',
		'battery_current',
		'charge_current',
		'mppt_voltage',
		'solar_n1_current',
		'solar_n2_current',
		'solar_e1_current',
		'solar_e2_current',
		'solar_s1_current',
		'solar_s2_current',
		'solar_w1_current',
		'solar_w2_current',
		'solar_t1_current',
		'solar_t2_current',
		'rails_switch_status',
		'rails_overcurrent_status',
		'rail_1_boot_count',
		'rail_1_overcurrent_count',
		'rail_1_voltage',
		'rail_1_current',
		'rail_2_boot_count',
		'rail_2_overcurrent_count',
		'rail_2_voltage',
		'rail_2_current',
		'rail_3_boot_count',
		'rail_3_overcurrent_count',
		'rail_3_voltage',
		'rail_3_current',
		'rail_4_boot_count',
		'rail_4_overcurrent_count',
		'rail_4_voltage',
		'rail_4_current',
		'rail_5_boot_count',
		'rail_5_overcurrent_count',
		'rail_5_voltage',
		'rail_5_current',
		'rail_6_boot_count',
		'rail_6_overcurrent_count',
		'rail_6_voltage',
		'rail_6_current',
		'3v3_voltage',
		'3v3_current',
		'5v_voltage',
		'5v_current',
  ];

	public $timestamps = false; //needed because I'm not using the default timestamp columns (updated_at, created_at), and otherwise php artisan tinker craps itself.

	public static $validation_rules = [];

	public function packet()
	{
		return $this->belongsTo('App\Packet');
	}
}
