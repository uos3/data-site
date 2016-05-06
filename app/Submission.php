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
		'cubesat_time',
		'temperature',
		'gyro_x',
		'gyro_y',    	
		'gyro_z',
		'accelerometer_x',
		'accelerometer_y',
		'accelerometer_z'    	
	];
}
