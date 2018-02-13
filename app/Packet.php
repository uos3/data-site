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

  protected $guarded = [
    'timestamp',
  ];

	public $timestamps = false; //needed because I'm not using the default timestamp columns (updated_at, created_at), and otherwise php artisan tinker craps itself.

	public static $validation_rules = [];


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
