<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
	protected $table = 'submissions';
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'uploaded_at',
		'user_id',
		'ip_address',
		'cubesat_time',
		'temperature',
		'gyro_x',
		'gyro_y',    	
		'gyro_z',
		'accelerometer_x',
		'accelerometer_y',
		'accelerometer_z'    	
	];
	
	public $timestamps = false; //needed because I'm not using the default timestamp columns (updated_at, created_at), and otherwise php artisan tinker craps itself.
	
	public static $validation_rules = [
		'uploaded_at' => 'required|date_format:Y-m-d H:i:s',
		'user_id' => 'integer|exists:users,id',
		'cubesat_time' => 'date_format:Y-m-d H:i:s',
		'temperature' => 'numeric',
		'gyro_x' => 'numeric',
		'gyro_y' => 'numeric',
		'gyro_z' => 'numeric',
		'accelerometer_x' => 'numeric',
		'accelerometer_y' => 'numeric',
		'accelerometer_z' => 'numeric',
	];
}
