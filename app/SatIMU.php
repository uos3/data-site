<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SatIMU extends Model
{
	protected $table = 'sat_imu';
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */

  protected $fillable = [
'submission_id',
'timestamp',
'mag_x',
'mag_y',
'mag_z',
'gyro_x',
'gyro_y',
'gyro_z',
'accel_x',
'accel_y',
'accel_z',
  ];

	public $timestamps = false; //needed because I'm not using the default timestamp columns (updated_at, created_at), and otherwise php artisan tinker craps itself.

	public static $validation_rules = [];

	public function packet()
	{
		return $this->belongsTo('App\Packet');
	}
}
