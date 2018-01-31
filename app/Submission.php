<?php

/*

new tables:

STATUS = primary submission table; has user_id and ip_address and a sequence_id that everything is supposed to relate to.

secondary submission tables
IMU = gyro etc
HEALTH = sat health data (temp, voltages,etc)
GPS = position

one submission = STATUS + 1 secondary table

switch by "submission type"? or a submission type array:

"submission": {
"HEALTH":TRUE,
"IMU":TRUE,
"GPS":FALSE
}

or:


"HEALTH": {},
"IMU":{},
"GPS":{
"lat":----,
"lon":----,

...
}

submit as JSON? probably wise, since there is a gazillion columns.

QUESTIONS:
* does id column link the submission together? (IMO should be called differently in secondary tables.)
* HEALTH does not have a SeqID column. Mistake?



*/

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
		'server_time',
		'downlink_time',
		'user_id',
		'ip_address',
		'sequence_id',
	];

	public $timestamps = false; //needed because I'm not using the default timestamp columns (updated_at, created_at), and otherwise php artisan tinker craps itself.

	public static $validation_rules = [
		'server_time' => 'required|date_format:Y-m-d H:i:s',
		'user_id' => 'integer|exists:users,id',
	];
}
