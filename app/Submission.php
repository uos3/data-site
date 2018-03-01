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

	public function binary()
	{
		return $this->hasOne('App\SubmissionBinary');
	}

	public function packet()
	{
		return $this->belongsTo('App\Packet');
	}
}
