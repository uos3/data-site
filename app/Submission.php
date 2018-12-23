<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
		'checksum_success',
		'packet_id',
	];

	public $timestamps = false; //needed because I'm not using the default timestamp columns (updated_at, created_at), and otherwise php artisan tinker craps itself.

	public static $validation_rules = [
		'server_time' => 'required|date_format:Y-m-d H:i:s',
		'user_id' => 'integer|exists:users,id',
	];

	public function binary()
	{
		return $this->hasOne('App\SubmissionBinary');
	}

	public function packet()
	{
		return $this->belongsTo('App\Packet');
	}


	public static function saveFailed($user_id, $ip, $packet_id = null,$downlink_time,$data_encoded) {

    $submission = new Submission([
      'server_time'=> Carbon::now()->toDateTimeString(),
      'user_id'=> $user_id,
      'ip_address'=>$ip,
      'packet_id'=>null,
      'checksum_success'=>false,
      'downlink_time'=>$downlink_time,
    ]);
    $submission->save();

    $binary = new SubmissionBinary([
      'data'=> $data_encoded,
      'submission_id'=>$submission->id,
    ]);
    $binary->save();
	}


	public static function saveSuccessful($user_id,$ip,$packet_id,$downlink_time,$data_encoded) {

		$submission = new Submission([
			'server_time'=> Carbon::now()->toDateTimeString(),
			'user_id'=> $user_id,
			'ip_address'=>$ip,
			'packet_id'=>$packet_id,
			'checksum_success'=>true,
			'downlink_time'=>$downlink_time,
		]);
		$submission->save();

		$binary = new SubmissionBinary([
			'data'=> $data_encoded,
			'submission_id'=>$submission->id,
		]);
		$binary->save();
	}
}
